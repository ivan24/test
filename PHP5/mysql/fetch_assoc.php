<?php ## Получение результата запроса.
require_once "mysql_connect.php";
// Выполняем запрос.
$r = mysql_query('SELECT * FROM people ORDER BY id')
  or die(mysql_error());
// Получаем ВЕСЬ результат в массив $data.
for ($data=array(); $row=mysql_fetch_assoc($r); $data[]=$row);
// Выводим массив на экран.
echo "<pre>"; print_r($data); echo "</pre>";
?>