<?php ## Пример библиотечного файла.
##
## Секция подключения необходимых библиотек.
##
# Подключаем библиотеку PEAR File_Find для поиска файлов.
require_once "File/Find.php";

##
## Секция определения главного пространства имен.
##
class MyFileFind {
  const EXT = "php";
  static $cache = array();
  function readdir($dir) {
    # Уже запрашивали содержимое этой директории?..
    # Если да, то берем предыдущий результат.
    if (isset(self::$cache[$dir])) return self::$cache[$dir];
    # Иначе вызываем функцию из File_Find, сохраняем
    # данные в кэше и возвоащаем результат.
    return self::$cache[$dir] = File_Find::glob(".*", $dir, self::EXT);
  }
}

##
## Секция автозапуска при подключении.
##
# Печатаем диагностическое сообщение (для примера).
echo "File ".__FILE__." loaded.<br>";
?>