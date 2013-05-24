<?php ## Пример использования библиотеки.
require_once "lib/config.php";
require_once "TestLib.php";
# ...
echo TestLib::length("abcd")."<br>";
echo TestLib::poweredLength("abcd");
?>