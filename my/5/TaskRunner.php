<?php
$classname = 'Task';
require_once("task/{$classname}.php");
$classname = "tasks\\$classname";
$obj = new $classname;
var_dump(get_class($obj));
$obj->doSpeak();
