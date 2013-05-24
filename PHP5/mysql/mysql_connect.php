<?php ## Подключение к СУБД MySQL.
$user = "root";
$pass = "";
$db   = "spoon";

// Подключаемся к СУБД MySQL.
mysql_connect("localhost", $user, $pass)
  or die("Could not connect: ".mysql_error());
// Создаем БД $db - это может делать только суперпользователь!
// Если БД уже существует, будет ошибка, но это не страшно.
@mysql_query('CREATE DATABASE $db');
// Выбираем БД $db (только что созданную или уже существующую).
mysql_select_db($db)
  or die("Could not select database: ".mysql_error());
?>