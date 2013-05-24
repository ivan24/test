<?php ## Проверка __autoload().
function __autoload($cls) {
  echo "Запрос на загрузку класса $cls<br>";
}
echo NonExisted::$a;
?>