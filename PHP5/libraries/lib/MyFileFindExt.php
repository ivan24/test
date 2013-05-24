<?php ## Наследующий модуль.
require_once "MyFileFind.php";

class MyFileFindExt extends MyFileFind {
  # Переопределяем имеющуюся функцию.
  public function readdir($dir) {
    echo "readdir($dir) called\n";
    # Вызываем исходную функцию из MyFileFind.
    return parent::readdir($dir);
  }
  # Новая функция.
  public function readcurdir() {
    return self::readdir(".");
  }
}

# Печатаем диагностическое сообщение (для примера).
echo "File ".__FILE__." loaded.\n";
?>