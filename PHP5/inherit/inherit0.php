<?php ## Проверка класса File_Logger_Debug0.
require_once "lib/config.php"; 
require_once "File/Logger/Debug0.php";
$logger = new File_Logger_Debug0("test", "test.log");
$logger->log("Обычное сообщение");
$logger->debug("Отладочное сообщение");
?>