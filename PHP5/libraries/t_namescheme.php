<?php ## Регистронезависимость имен классов.
require_once "lib/config.php";
require_once "PEAR/NameScheme.php";

# Все три команды выведут одинаковый результат.
echo PEAR_NameScheme::name2path("PHP_Autoload")."<br>";
echo PEAR_NameScheme::name2path("php_autoload")."<br>";
echo PEAR_NameScheme::name2path("PHP_AUTOLOAD")."<br>";
?>