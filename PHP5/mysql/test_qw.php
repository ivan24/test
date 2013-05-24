<?php
require_once "lib/mysql_qw.php";
require_once "mysql_connect.php";
// Представим, что мы - хакеры...
$name = "' OR '1";
// Допустимый запрос.
echo mysql_make_qw('DELETE FROM people WHERE name=?', $name)."<br>";
// Недопустимый запрос.
echo mysql_make_qw('DELETE FROM people WHERE name=? OR ?', $name)."<br>";
// Вот как выглядит выполнение запроса.
mysql_qw('DELETE FROM people WHERE name=? OR ?', $name)
  or die(mysql_error());
?>