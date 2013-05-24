<?php
require_once "Cache/Directory.php";

class Cache_Site extends Cache_Directory
{
    var $VERSION = "1.01";
    
    function Cache_Site($basedir="/tmp", $timeout=false) {
        Cache_Directory::Cache_Directory($basedir."/".strtolower($_SERVER["SERVER_NAME"]), $timeout);
    }
}
?>