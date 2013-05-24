<?php
require_once "Cache/Validity.php";

class Cache_Validity_Timestamp extends Cache_Validity
{
    var $files = array();

    // Add dependent file.
    function add($fname)
    {
        $fname = $fname;
        $this->files[$fname] = file_exists($fname)? filemtime($fname) : null;
    }

    // Check validity.
    function check($stamp)
    {
        foreach ($this->files as $fname=>$t) {
            $stamp = file_exists($fname)? filemtime($fname) : null;
            if ($t !== $stamp) return false;
        }
        return true;
    }
}
?>