<?php
namespace my;
use example\Debug as Test;
class Debug
{
    static function hello()
    {
        print __CLASS__;
    }
}
require_once './Debug1.php';
Debug::hello();
print "\n";
Test::hello();
