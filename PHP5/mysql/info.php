<?php ## Получение информации о таблице.
require_once "mysql_connect.php";
// Получаем все данные таблицы.
$result = mysql_query('SELECT * FROM people');
// Запрашиваем идентификатор данных о полях таблицы.
$fields = mysql_num_fields($result);
// Узнаем число записей в таблице.
$rows   = mysql_num_rows($result);
// Получаем имя таблицы (правда, мы его и так знаем, но все же...).
$table = mysql_field_table($result,0);
echo "Таблица '$table' содержит $fields колонок и $rows строк<BR>";
echo "Таблица содержит следующие поля:<BR>";
// "Проходимся" по всем полям и выводим информацию о них.
for ($i=0; $i<$fields; $i++) {
  $type  = mysql_field_type($result, $i);
  $name  = mysql_field_name($result, $i);
  $len   = mysql_field_len($result, $i);
  $flags = mysql_field_flags($result, $i);
  echo "$name $type($len) $flags<BR>\n";
}
?>
