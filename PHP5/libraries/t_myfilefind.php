<?php ## Пример использования библиотеки.
require_once "lib/config.php";
# На случай, если у вас не установлен PEAR, используем PEAR-модули,
# входящие в этот архив (в данном случае PEAR и File_Find).
require_once "lib-pear/config.php";
require_once "MyFileFind.php";
echo "<pre>Содержимое корневого каталога:\n";
print_r(MyFileFind::readdir("/")); # подгружает содержимое директории
print_r(MyFileFind::readdir("/")); # второй раз данные взяты из кэша
echo "Вот что в итоге находится в кэше модуля:\n";
print_r(MyFileFind::$cache);       # выводит содержимое кэша
?>