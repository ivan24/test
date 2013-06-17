<?php
$str = 'ivan\\test\\cool.php';

$file = substr($str, strrpos($str, '\\')+1);
$namespace = substr($str, 0, strrpos($str, '\\') - (strlen($str)-1));

var_dump($file,$namespace,$str);
