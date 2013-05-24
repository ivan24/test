<?php ## Простейшая гостевая книга.
require_once "mysql_connect.php";
require_once "lib/mysql_qw.php";

// Имя таблицы.
define("TBLNAME", "guestbook");

// Создаем таблицу, если ее еще не существовало.
mysql_qw('
  CREATE TABLE IF NOT EXISTS '.TBLNAME.' (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    stamp  TIMESTAMP,
    name   VARCHAR(60),
    text   TEXT
  ) 
') or die(mysql_error());

// Обрабатываем кнопки и действия.
if (@$_REQUEST['doAdd']) {
  // Получаем данные из формы.
  $element = $_REQUEST['element'];
  // Удаляем слэши в данных, которые PHP вставил в режиме 
  // magic_quotes_gpc (если он включен).
  if (ini_get("magic_quotes_gpc"))
    $element = array_map('stripslashes', $element);
  // Вставляем запись.
  mysql_qw(
    'INSERT INTO '.TBLNAME.' SET name=?, text=?',
    $element['name'], $element['text']
  ) or die(mysql_error());
  // Выполняем "самопереадресацию", чтобы при нажатии на кнопку
  // "Обновить" в браузере сообщение не добавлялось снова и снова.
  Header("Location: {$_SERVER['SCRIPT_NAME']}?".time());
  exit();
}

// Удаление сообщения с указанным ID.
if ($delid = @$_REQUEST['delete']) {
  mysql_qw('DELETE FROM '.TBLNAME.' WHERE id=?', $delid)
    or die(mysql_error());
}

// Выбираем все записи из таблицы, начиная с самой новой.
$result = mysql_qw('
  -- Функция MySQL UNIX_TIMESTAMP() конвертирует timestamp
  -- из формата MySQL в число секунд с начала эпохи Unix.
  SELECT *, UNIX_TIMESTAMP(stamp) AS stamp
  FROM '.TBLNAME.' 
  ORDER BY stamp DESC
') or die(mysql_error());
for ($book=array(); $row=mysql_fetch_array($result); $book[]=$row);
?>
<!-- Далее идет шаблон книги. -->
<form action="" method="post">
<table>
<tr valign="top">
  <td>Ваше имя:</td>
  <td><input type="text" name="element[name]"></td>
</tr>
<tr valign="top">
  <td>Текст сообщения:</td>
  <td><textarea name="element[text]" cols="60" rows="5"></textarea></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="doAdd" value="Добавить"></td>
</table>
</form>
<hr>
<?foreach($book as $element) {?>
  <b>
    <?=date("d.m.Y", $element['stamp'])?> 
    <?=htmlspecialchars($element['name'])?>
  </b> написал:
  <a href="<?=$_SERVER['SCRIPT_NAME']?>?delete=<?=$element['id']?>">
    [удалить]</a>
  <br>
  <blockquote>
    <?=nl2br(htmlspecialchars($element['text']))?>
  </blockquote>
  <hr>
<?}?>