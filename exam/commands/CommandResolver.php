<?php
namespace Command;

use Controller\Request;

class CommandResolver
{
    private static $base_cmd;
    private static $default_cmd;

    public function __construct()
    {
        if (!self::$base_cmd) {
            self::$base_cmd = new \ReflectionClass("\\Command\\Command");
            self::$default_cmd = new DefaultCommand();
        }
    }

    public function getCommand(Request $request)
    {
        $cmd = $request->getProperty('cmd');
        $sep = DIRECTORY_SEPARATOR;
        if (!$cmd) {
            return self::$default_cmd;
        }
        $cmd = str_replace(array('.', $sep), "", $cmd);
        $filePath = __DIR__ . "{$sep}{$cmd}.php";
        $className = "\\Commands\\$cmd";
        if (file_exists($filePath)) {
            require_once("$filePath");
            if (class_exists($className)) {
                $refleClass = new \ReflectionClass($className);
                if ($refleClass->isSubclassOf(self::$base_cmd)) {
                    return $refleClass->newInstance();
                }
            }
        }
        $request->addFeedback("Command $cmd doen't find");
        return clone self::$default_cmd;
    }
}
require_once __DIR__."/Command.php";
require_once __DIR__."/DefaultCommand.php";