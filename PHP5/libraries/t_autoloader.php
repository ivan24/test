<?php ## Пример использования классов для автозагрузки.
require_once "lib/config.php";
# На случай, если у вас не установлен PEAR, используем PEAR-модули,
# входящие в этот архив (в данном случае PEAR и File_Find).
require_once "lib-pear/config.php";
require_once "PEAR/NameScheme/Autoload.php";
# Начиная с этого момента классы подгружаются автоматически.
echo "<pre>Файлы в текущей директории:\n";
# Как пример - используем написанный раньше модуль MyFileFind.
print_r(MyFileFind::readdir("."));
?>