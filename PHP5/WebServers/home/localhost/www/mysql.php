<?php ## Скрипт для проверки работоспособности MySQL.
echo "<pre>";
// Открываем соединение с СУБД MySQL:
// Пользователь: root, пароль: пустой.
@mysql_connect("localhost", "root", "")
  or die(mysql_error());
// Будем работать с базой данных "mysql" (существует по 
// умолчанию и хранит концигурацию сервера MySQL).  
@mysql_select_db("mysql")
  or die(mysql_error());
// Выбираем все записи из таблицы "users" БД "mysql".
$r = @mysql_query("SELECT * FROM user")
  or die(mysql_error());
// В цикле печатаем каждую найденную строку.  
while ($row = mysql_fetch_assoc($r)) {
  print_r($row);
}
?>