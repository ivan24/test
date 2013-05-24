<?php
require_once "Subsys/Templier/Main.php";
require_once "Subsys/Smarty/libs/Smarty.class.php";
require_once "Cache/Directory.php";
require_once "Debug/BacktraceDumper.php";
require_once "File/Path.php";

class Subsys_Templier_Smarty extends Subsys_Templier_Main
{
    var $VERSION   = "1.10";

    # Privates.
    var $smarty       = null;
    var $cacheCompile = null;  # cache for compiling templates
    var $cacheCache   = null;  # cache for context cache
    var $errors       = array();

    # Construector.
    function Subsys_Templier_Smarty($uriRoot, $cache)
    {
        # Prepare base Templier class.
        $this->config = array_merge($this->config, array(
            'common' => '.common',
            'lib'    => array(
                dirname(__FILE__)."/Smarty/plugin",
                dirname(__FILE__)."/Smarty/component",
            ),
        ));
        $this->Subsys_Templier_Main($uriRoot);

        # Prepare cache
        $c = $cache->getSubcache("Subsys_Templier_Smarty");
        $this->cacheCompile = $c->getSubcache("compiled");
        $this->cacheCache   = $c->getSubcache("cache");

        # Prepare Smarty.
        $smarty =& new Smarty();
        $smarty->error_reporting = error_reporting();
        $smarty->template_dir    = (array)$smarty->template_dir;
        $this->smarty =& $smarty;

        $this->_refreshSmarty();

        ##!!!
        ##!!! DO NOT set $this->smarty->Subsys_Templier here!!!
        ##!!! Somewhere deep inside Smarty $this is copied (maybe = used instead of =&).
        ##!!!
    }

    # Context factory.
    function& createContext($uri)
    {
        return new Subsys_Templier_Smarty_Context($uri, $this);
    }

    # Return dependent cache object.
    function getCache($deps, $human=null)
    {
        return $this->cacheCache->getFile($deps, $human);
    }

    # mixed runComponent($className, mixed $params)
    # Loads and calls specified component ($className::main).
    # Returns result of static main() method.
    function runComponent($class, $params)
    {
        require_once "PEAR/NameScheme.php";
        // Temporarily set include_path for class searching.
        $pathes = array_merge(PEAR_NameScheme::getInc(), $this->config['lib']);
        $sep = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')? ";" : ":";
        $old = ini_set("include_path", join($sep, $pathes));
        $fname = PEAR_NameScheme::name2path($class, true);

        // On error - return.
        if (!$fname) {
            trigger_error("croak[2]: Could not find source file for class $class.", E_USER_ERROR);
            $result = false;
        } else {
            // Load code.
            require_once($fname);
            // Run the component
            $cwd = getcwd();
            chdir(dirname($fname));
            $result = parent::runComponent($class, $params);
            chdir($cwd);
        }
        ini_set("include_path", $old);
        return $result;
    }


    # This function includes the specified PHP file.
    function runTheFile($fname, $ARGS=false)
    {
        # Handle all the errors.
        set_error_handler(array(&$this, "_errorHandler"));
            # Setup Smarty.
            $this->_refreshSmarty();
            # Setup caching.
            $this->smarty->compile_dir = $this->cacheCompile->getDir();
            $this->smarty->compile_id  = $this->_path2Hash(dirname($fname));
            $this->smarty->caching = false;
            # Save $this in Smarty object (to fetch in plugins).
            $prevTempl =& $this->smarty->Subsys_Templier;
            $this->smarty->Subsys_Templier =& $this;
                # Call Smarty.
                $this->smarty->fetch($fname);
            # Delete temporary reference to $this.
            $this->smarty->Subsys_Templier =& $prevTempl;
        # Restore prev error handler.
        restore_error_handler();

        # Draw all errors.
        if ($this->errors) {
            foreach ($this->errors as $e) $e->show();
            $this->errors = array();
        }
    }

    //
    // Privates.
    //
    var $__privates; // dummy

    # Refresh Smarty internal variables from Templier config.
    # Must be called before running any Smarty template.
    function _refreshSmarty()
    {
        $smarty =& $this->smarty;
        # Load plugins.
        $load = array();
        foreach ($this->config['lib'] as $dir) {
            if (in_array($dir, $smarty->plugins_dir)) continue;
            array_unshift($smarty->plugins_dir, $dir);
            $d = glob("$dir/*filter.*");
            if (!$d) continue;
            foreach ($d as $f) {
                if (!preg_match('/^(.*)filter\.(.*?)\./', basename($f), $p)) continue;
                $load[$p[2]] = $p[1];
            }
        }
        foreach ($load as $name=>$type) {
            $smarty->load_filter($type, $name);
        }
    }


    # Converts FS path to hash string.
    function _path2Hash($path)
    {
        return preg_replace('{[\\\\/:]}', '_', $path);
    }

    # Collects all errors and warnings.
    function _errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (!($errno & error_reporting())) return;
        $trace = new Debug_BacktraceDumper();
        $trace->prepare($errno, $errstr, $errfile, $errline, 2);
        $trace->show();
    }


    ##
    ## Pragmas.
    ##
    var $__pragmas;// dummy

    # @Common
    function _pragma_Common(&$blk)
    {
        $blk->value = trim($blk->value);
        $this->config['common'] = $blk->value;
        return true;
    }

    # @Lib
    function _pragma_Lib(&$blk)
    {
        $blk->value = $this->context->absolutizePath(trim($blk->value));
        $this->config['lib'][] = $blk->value;
        return true;
    }

    # @Path override
    function _pragma_Path(&$blk)
    {
        if (!parent::_pragma_Path($blk)) return false;
        $this->smarty->template_dir[] = $blk->context->uri2Path($blk->value);
        return true;
    }
}


# Filesystem-based context.
class Subsys_Templier_Smarty_Context extends Subsys_Templier_Context {
    var $fname;          # full OS-depend filename (always filename)
    var $path;           # full OS-depend path (may be directory)
    var $cwd = null;

    # Constructor.
    function Subsys_Templier_Smarty_Context($uri, &$owner)
    {
        $this->Subsys_Templier_Context($uri, $owner);
        if (!parent::isValid()) return;
        $this->path = $this->uri2Path($this->uri);
        if (!$this->isValid()) return;
        if ($this->isDir()) {
            $this->fname = File_Path::gluePath($this->path, $this->owner->config['common']);
            if ($this->uri{strlen($this->uri)-1}!='/') $this->uri .= '/';
        } else {
            $this->fname = $this->path;
        }
    }

    # Return context data without references (for templates).
    function getDump() {
        $dump = parent::getDump();
        $dump['isdir'] = $this->isDir();
        $dump['fname'] = $this->fname;
        $dump['basename'] = basename($this->fname);
        return $dump;
    }

    # Returns true if URI is valid.
    function isValid()
    {
        return parent::isValid() && file_exists($this->path);
    }

    # Returns true if the URI is directory, not a file
    function isDir()
    {
        return is_dir($this->path);
    }

    # Make current context active.
    function activate(&$old)
    {
        if ($old) $old->cwd = getcwd();
        chdir($this->cwd? $this->cwd : dirname($this->fname));
    }

    # Run the block file.
    function run($args)
    {
        # If the file is valid but not exists, it is htaccess.
        if ($this->isDir() && !file_exists($this->fname)) return;
        $this->owner->runTheFile($this->fname);
    }

    # Return array of children contexts.
    function& getChildren()
    {
        $children = array();
        for ($d=opendir($this->path); false !== ($fn=readdir($d)); ) {
            if ($fn{0} == ".") continue;
            if ($fn == $this->owner->config['common']) continue;
            $uri = $this->uri . ($this->uri{strlen($this->uri)-1}!='/'? '/' : '') . $fn;
            $context =& $this->owner->createContext($uri);
            $children[] =& $context;
        }
        return $children;
    }

    ##
    ## Filesystem-related functions.
    ##

    # Returns absolute path by URI.
    function uri2Path($name)
    {
        $curUri = dirname($_SERVER["SCRIPT_NAME"]);
        $uri = File_Path::absPath(trim($name), $curUri);
        return $_SERVER["DOCUMENT_ROOT"].$uri;
    }

    function absolutizePath($name)
    {
        return File_Path::absPath(trim($name), dirname($this->fname));
    }
}
?>