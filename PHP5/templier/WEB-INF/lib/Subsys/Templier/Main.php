<?php

// Abstract class.
// This class is fully filename-independent: it works with URIs only!
// The exception is Component URIs which is translated
class Subsys_Templier_Main
{
    // Pragma name prefix.
    var $PRAGMA_PRE = "@";

    // Config block names.
    var $blkLayout   = "@Layout";        // page layout name
    var $blkOutput   = "@Output";        // this block will be printed to browser

    // Contexts.
    var $rootContext    = null;
    var $requestContext = null;      // Request context.
    var $context        = null;      // Current context.

    // All the blocks array.
    var $_blocks  = array();

    // Config data.
    var $config = array();


    //
    // Templier API.
    //

    // Constructor.
    function Subsys_Templier_Main($uriRoot)
    {
        $this->config = array_merge($this->config, array(
            'index'    => array('index\..+'),
            'modifier' => array('.*' => array(
                "Subsys_Templier_Main::_modifier_DelEmptyLines",
                "Subsys_Templier_Main::_modifier_DelTabs",
            )),
            'path'     => array(),
        ));
        $this->rootContext =& $this->createContext($uriRoot);
        $this->_switchContext($this->rootContext);
    }

    // Search for nsme in @Path. Return found context or NULL if nothing is found.
    function findContext($name)
    {
        if ($this->context->isAbsolute($name)) return $this->createContext($name);
        $inc = $this->config['path'];
        array_unshift($inc, $this->context->uri);
        foreach($inc as $r) {
            $path = $this->context->gluePath($r, $name);
            $c = $this->createContext($path);
            if ($c->isValid()) return $c;
        }
        return null;
    }

    // Returns ALL blocks with specified name.
    function findBlocks($name)
    {
        $name = strtolower($name);
        if (!isset($this->_blocks[$name])) return array();
        return $this->_blocks[$name];
    }

    // Returns the block body. Case-insensetive.
    function findBlock($name)
    {
        $blk = $this->findBlocks($name);
        if (!$blk) return null;
        return $blk[count($blk)-1];
    }

    // Returns the block body. Case-insensetive.
    function getBlockBody($name)
    {
        $blk = $this->findBlock($name);
        if (!$blk) return null;
        return $blk->value;
    }

    // Returns the block body. Case-insensetive.
    function getBlockBodies($name)
    {
        $blks = $this->findBlocks($name);
        $bodies = array();
        foreach ($blks as $blk) $bodies[] = $blk->value;
        return $bodies;
    }

    // Adds the new block to the block list. Body MUST be specified.
    // Currend block is not switched.
    function addBlock($name, $value, $isRaw=false)
    {
        $name = trim(strval($name));
        if ($name === "") return;
        // Initializing the new block.
        $newBlock =& new Subsys_Templier_Block();
        $newBlock->name    = $name;
        $newBlock->value   = $value;
        $newBlock->raw     = $isRaw;
        $newBlock->context =& $this->context;
        // Run modifiers.
        if (!$this->_preprocessBlock($newBlock)) return;
        $this->_blocks[strtolower($name)][] = $newBlock;
    }

    // Loads & parses the block file. All blocks of this file
    // will be added to block list. If there was current block,
    // it will be placed AFTER all the blocks in loaded file.
    function loadUri($uri, $args=null)
    {
#        echo "$uri<br>";
        // Creates the new context by its URI, inheriting
        // previous context data.
        $newContext =& $this->findContext($uri);

        // Maybe this file or directory does not exist?..
        if (!$newContext || !$newContext->isValid()) die("Templier: couldn't open \"$uri\"!");

        // Activates the new context.
        $oldContext =& $this->_switchContext($newContext);

        // Run the file.
        $newContext->run($args);

        // Switches the context back.
        $this->_switchContext($oldContext);

        return $newContext->uri;
    }

    // The main Templier function. Processes specified $uri
    // and returns the contents of Output block. Nothing is printed
    // to stdout, except warnings, maybe.
    function runUri($uri=null)
    {
        $this->requestContext = $this->findContext($uri);
        if (!$this->requestContext->isValid()) return null;
        $this->_switchContext($this->requestContext);

        // Collects all the blocks from subdirs.
        $this->_collectBlocks($this->requestContext);

        // Fing & run the main layout. We must do it at the end,
        // ro make all the blocks to be accessible. Tamplate - is usual
        // text file with REQUIRED block Output.
        $tmpl = $this->getBlockBody($this->blkLayout);
        if (!$tmpl) die(
            "Cannot find the layout for <b>$uri</b> ".
            "(have you defined <tt>{$this->blkLayout}</tt> block?)"
        );
        $this->loadUri($tmpl);

        // Returns Output block.
        $out = $this->getBlockBody($this->blkOutput);
        if (!$out) die(
            "No output from layout <b>$tmpl</b> ".
            "(have you defined <tt>{$this->blkOutput}</tt> block?)"
        );
        return $out;
    }

    // mixed runComponent($className, mixed $params)
    // Ñall specified Ñomponent ($className::main).
    // Component class must be already loaded before.
    // Returns result of static main() method.
    function runComponent($class, $params)
    {
        $base = "Subsys_Templier_Component";
        $component = new $class($this);
        if (!is_a($component, $base)) {
            die("Component class $class is not derived from $base.");
        }
        $component->templier =& $this;
        $result = $component->_generate($params, &$this);
        return $result;
    }


    //
    // Abstracts.
    //
    var $__abstracts; // dummy

    // Creates the new context based on context $parent.
    // This function may be overriden in derived classes.
    // It must solve absolute pathes by relative URI.
    function& createContext($uri)
    {
        die("createContext(): pure function called");
    }

    // Return dependent cache object.
    function getCache($deps, $human=null)
    {
        die("getCache(): pure function called");
    }


    //
    // Private functions.
    //
    var $__privates;

    // Switches the templier context to another.
    // Returns previous active context.
    function& _switchContext(&$context)
    {
        if ($context->activate($this->context) === false)
            return $this->context;
        $old =& $this->context;
        $this->context =& $context;
        return $old;
    }

    // This function walks down through the site tree & loads
    // all the htaccess block files.
    function _collectBlocks($context)
    {
        // If we are NOT at "/", use up-dir.
        if (!$context->isRoot()) {
            $parent = $context->getParent();
            $this->_collectBlocks($parent);
        }
        // Load own blocks.
        $this->loadUri($context->uri);
    }

    // Runs all the filters for this block. It also clears the
    // current block pointer in this block context.
    // Return false if block must be dropped.
    function _preprocessBlock(&$blk)
    {
        // Complex (non-scalar) blocks are not processed.
        if (is_array($blk->value) || is_object($blk->value)) return true;

        // Check for pragma.
        $name = strtolower($blk->name);
        if (strpos($name, $this->PRAGMA_PRE) === 0) {
            $pragma = substr($name, strlen($this->PRAGMA_PRE));
            $func = "_pragma_".ucfirst($pragma);
            if (method_exists($this, $func)) {
                $r = call_user_func(array(&$this, $func), &$blk);
                if (!$r) return false;
            }
        }

        // Run modifiers.
        if ($blk->raw) return true;
        foreach (array_reverse($this->config['modifier']) as $re=>$codes) {
            if (!preg_match("/^(?:$re)$/si", $blk->name)) continue;
            foreach (array_reverse($codes) as $code) {
                list ($cls, $name) = explode("::", $code);
                if (!$name) { $name = $cls; $cls = null; }
                $blk->value = call_user_func($cls? array($cls, $name) : $name, $blk->value, &$this, $blk);
                if ($blk->value === false) return false;
            }
        }

        // All done.
        return true;
    }

    // Creates RE from shell mask.
    // If mask looks like '/.../', it is treated as RE itself.
    function _makeRe($mask)
    {
        $mask = trim($mask);
        if (preg_match('{^/(.*)/$}', $mask, $p)) return $p[1];
        $mask = preg_quote($mask, '/');
        $mask = str_replace(
            array('\\*', '\\?'),
            array('.*',  '.'  ),
            $mask
        );
        return $mask;
    }


    //
    // Protected pragmas.
    //
    var $__pragmas; // dummy

    // @Inc.
    function _pragma_Inc(&$blk) 
    {
        $blk->name = $this->PRAGMA_PRE."Path";
        return $this->_pragma_Path($blk);
    }

    // @Path.
    function _pragma_Path(&$blk)
    {
        $context = $blk->context->getRelative(trim($blk->value));
        if (!$context) return true;
        $blk->value = $context->uri;
        $this->config['path'][] = $context->uri;
        return true;
    }

    // @Index
    function _pragma_Index(&$blk)
    {
        $blk->value = trim($blk->value);
        $re = $this->_makeRe($blk->value);
        $this->config['index'][] = "(?:$re:)";
        return true;
    }

    // @Modifier
    function _pragma_Modifier(&$blk)
    {
        $blk->value = trim($blk->value);
        list ($ex, $code) = preg_split('/\s+/', $blk->value, 2);
        $this->config['modifier'][$this->_makeRe($ex)][] = $code;
        return true;
    }

    // @Include
    function _pragma_Include(&$blk)
    {
        $this->loadUri(trim($blk->value));
        return false;
    }


    //
    // Modifier functions.
    //
    var $__modifiers;

    // Trims the spaces & prepended tabs.
    // Now you can easily format HTML-êîä with tab.
    function _modifier_DelTabs($st)
    {
        return preg_replace("/^\t*(#.*\r?\n?)?/m", "", $st);
    }

    // Removes leading and training spaced lines.
    function _modifier_DelEmptyLines($st) {
        return preg_replace('/^([ \t]*[\r\n]+)+ | ([\r\n]+[ \t]*)+$/sx', '', $st);
    }
}


// Abstract.
// Information about current processing file (or directory).
class Subsys_Templier_Context {
    // Properties.
    var $owner  = null;      // Templier object
    var $uri    = null;      // full URI (may be directory)
    var $query  = null;      // query-string
    var $curBlk = null;      // current handled block

    // Constructor. May use only ABSOLUTE uris.
    function Subsys_Templier_Context($uri, &$owner)
    {
        if (!$this->isAbsolute($uri)) return;
        $this->owner =& $owner;
        $parts = $this->splitQuery($uri);
        $this->uri = $parts[0];
        if (count($parts) > 1) $this->query = $parts[1];
        $this->uri = $this->delDots($this->uri);
    }

    // Return context relative to current DIRECTORY.
    // Example: getRelative("../../file").
    function& getRelative($name)
    {
        if ($this->isAbsolute($name)) return $this->owner->createContext($name);
        if (!$this->isDir()) $cur = $this->dirname($this->uri);
        else $cur = $this->uri;
        $c = $this->owner->createContext($this->gluePath($cur, $name));
        if ($c->isValid()) return $c;
        return null;
    }

    // Return parent context.
    function getParent()
    {
        return $this->owner->createContext($this->dirname($this->uri));
    }

    // Checks for context existance.
    function isValid()
    {
        return $this->uri !== null;
    }

    // Return true if URI part matches the SCRIPT_NAME.
    function isActive()
    {
        $a = $this->getCanonizedUri(true);
        $b = $this->owner->requestContext->getCanonizedUri(true);
        return $a == $b;
    }

    // Return true if URI matches EXACTLY REQUEST_URI.
    function isCurrent()
    {
        $a = $this->getCanonizedUri();
        $b = $this->owner->requestContext->getCanonizedUri();
        return $a == $b;
    }

    // string canonizeUri()
    // Translate URI to shortest canonical name:
    //   foo/index.html -> foo/
    function getCanonizedUri($noQuery = false)
    {
        $basename = $this->basename($this->uri);
        $indexRe = join('|', $this->owner->config['index']);
        if (preg_match("{^(?:$indexRe)$}s", $basename)) {
            $uri = substr($this->uri, 0, -strlen($basename));
        } else {
            $uri = $this->uri;
        }
        if ($noQuery) return $uri;
        return $uri . ($this->query !== null? '?'.$this->query : '');
    }


    // Return context data without references (for templates).
    function getDump() {
        return array(
            'uri'      => $this->getCanonizedUri(),
            'active'   => $this->isActive(),
            'current'  => $this->isCurrent()
        );
    }


    //
    // Abstract.
    //

    // Returns true if the URI is folder.
    function isDir()
    {
        die("isDir(): pure function called. Too few information at this time.");
    }

    // Activate this context.
    // Called before running this context.
    // If this method returns ===false, activation is cancelled.
    function activate(&$old)
    {
        die("activate(): pure function called.");
    }


    //
    // URI grammar.
    //

    function dirname($uri)
    {
        return str_replace('\\', '/', dirname($uri));
    }

    function basename($uri)
    {
        return basename($uri);
    }

    function gluePath($a, $b)
    {
        return $a . ($a{strlen($a)-1} == '/'? '' : '/') . $b;
    }

    function isAbsolute($uri)
    {
        if (strval($uri) === "") return false;
        return $uri{0} == '/';
    }

    function delDots($uri)
    {
        return File_Path::absPath($uri);
    }

    function splitQuery($url)
    {
        return explode('?', $url, 2);
    }

    // Return true if this is a root context.
    function isRoot()
    {
        return $this->uri == "/" || preg_replace('{/+$}s', '', $this->uri) == preg_replace('{/+$}s', '', $this->owner->rootContext->uri);
    }
}


// Block data.
class Subsys_Templier_Block 
{
    var $context = null;             // this block context (set at the end of processing)
    var $name;                       // name of the block
    var $value  = "";                // block body contents
    var $raw    = false;             // do not apply modifiers to this block

    // Return block data without references (for templates).
    function getDump() 
    {
        return array(
            'name'    => $this->name,
            'value'   => $this->value,
            'context' => $this->context->getDump(),
        );
    }
}


// Version-independent.
class Subsys_Templier_Component_Independent
{
    var $croakOffset    = 6;
    var $templier       = null;
    var $globalValidity = null;

    // Drops error message to caller context.
    function croak($msg, $level=E_USER_ERROR)
    {
        $this->templier->smarty->trigger_error("croak[{$this->croakOffset}]: $msg", $level);
    }

    // Entry point of component.
    function _generate($params, &$templier)
    {
        // Try to load from the cache.
        $cache  = $this->getCache(array(
            "GLOBAL COMPONENT CACHE",  // any characters
            filemtime(__FILE__),       // this file mtime
            $params                    // component parameters
        ));
        $result = $cache->retrieve();
        if ($result !== null) return $result;

        // Call generator.
        $result = $this->main($params, $templier);
        if ($result === false) return $result;

        // Store cache if validity is present.
        if ($this->globalValidity)
            $cache->store($result, $this->globalValidity);

        return $result;
    }

    // Return named cache object for THIS COMPONENT personally.
    function getCache($deps=null)
    {
        return $this->templier->getCache($deps, get_class($this));
    }

    // Set THIS COMPONENT validity object.
    function setValidity(&$validity)
    {
        $this->globalValidity =& $validity;
        return true;
    }
}


// Version-dependent code. PHP4 does not support "abstract".
if (version_compare(phpversion(), "5.0.0") >= 0) {
    eval('
        abstract class Subsys_Templier_Component extends Subsys_Templier_Component_Independent
        {
            abstract function main($params, &$templier);
        }
    ');
} else {
    eval('
        class Subsys_Templier_Component extends Subsys_Templier_Component_Independent
        {
            function main($params, &$templier) {
                trigger_error("Pure virtual function called!", E_USER_ERROR);
                return;
            }
        }
    ');
}
?>