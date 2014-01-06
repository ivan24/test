<?php
$arr = new \ArrayAccess\MyarrayAccess();
$arr['first'] = 'test';
var_dump($arr['first']);
unset($arr['first']);
unset($arr['test']);