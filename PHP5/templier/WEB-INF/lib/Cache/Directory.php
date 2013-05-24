<?php
require_once "File/Path.php";

class Cache_Directory
{
    var $VERSION = "1.02";

    var $dir = false;
    var $timeout = false;

    function Cache_Directory($basedir="/tmp", $timeout=false)
    {
        $this->dir = $basedir;
        File_Path::mkdirs($this->dir, 0770);
        $this->dir = realpath($this->dir);
    }

    function getSubcache($sys)
    {
        return new Cache_Directory($this->dir."/".$this->_mangle($sys));
    }

    function getTimeout()
    {
        return $this->timeout;
    }

    function getDir()
    {
        return $this->dir;
    }

    function getFile($deps, $human=false)
    {
        return new Cache_Directory_File($this, $deps, $human);
    }
    
    function _mangle($path)
    {
        $id = preg_replace('{[\\\\/]}s', '^', $path);
        $id = preg_replace('{[^-\w_=!^.]}s', '_', $id);
        if ($id != $path) $id .= crc32($path);
        return $id;
    }
}


class Cache_Directory_File
{
    var $SIGNATURE = "Cache_File\x001";
    var $parent = false;
    var $fname = false;

    function Cache_Directory_File(&$parent, $deps, $human=false)
    {
        $this->parent =& $parent;
        $fname = md5(Serialize(array($human, $deps)));
        if ($human !== false)
            $fname = preg_replace("/[^a-z0-9-_=]/is", "_", $human)."-".$fname;
        $this->fname = $parent->getDir()."/".$fname.".cache";
    }

    function store($data, $validity=null)
    {
        // Create empty file if it does not exists.
        if (!@fclose(fopen($this->fname, "a+b"))) return $data;
        $f = fopen($this->fname, "w+b");
        flock($f, LOCK_EX);
        ftruncate($f, 0);
        // Signature.
        fwrite($f, $this->SIGNATURE);
        // Validity.
        $validity = array(time(), $validity);
        $v = serialize($validity);
        fwrite($f, pack("V", strlen($v))); fwrite($f, $v);
        // Data.
        $v = serialize($data);
        fwrite($f, pack("V", strlen($v))); fwrite($f, $v);
        fclose($f);
        return $data;
    }

    function retrieve($checker=null)
    {
        $f = @fopen($this->fname, "rb");
        if (!$f) return null;
        flock($f, LOCK_SH);
        $timeout = $this->parent->getTimeout();
        $bad = true;
        $data = null;
        do {
            // Check by expiration time?
            if ($timeout && time() - filemtime($this->fname) >= $timeout) break;
            // Signature.
            $sig = fread($f, strlen($this->SIGNATURE));
            if ($sig !== $this->SIGNATURE) break;
            // Validity.
            $len = current(unpack("V", fread($f, 4)));
            $validity = unserialize(fread($f, $len));
            list ($stamp, $validity) = $validity;
            // Check validity.
            if ($validity !== null) {
                if (is_object($validity) && is_a($validity, "Cache_Validity")) {
                    if (!$validity->check($stamp)) break;
                }
                if ($checker && !call_user_func($checker, $validity, $stamp)) break;
            }
            // Read the tail & parse.
            $len = current(unpack("V", fread($f, 4)));
            $data = unserialize(fread($f, $len));
            $bad = false;
        } while (0);
        fclose($f);
        // Cache is invalid?
        if ($bad) {
            unlink($this->fname);
            return null;
        }
        return $data;
    }
}

?>