<?php ## Наследование модулей.
require_once "lib/config.php";
# На случай, если у вас не установлен PEAR, используем PEAR-модули,
# входящие в этот архив (в данном случае PEAR и File_Find).
require_once "lib-pear/config.php";
require_once "MyFileFindExt.php";
echo "<pre>";
print_r(MyFileFindExt::readdir("/")); # подгружает содержимое директории
print_r(MyFileFindExt::readcurdir()); # второй раз данные взяты из кэша
?>
