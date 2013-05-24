<?php ## Обработчик шаблонизатора.
require_once "lib/config.php";
require_once "Subsys/Templier/ApacheHandler.php";
require_once "Subsys/Templier/Smarty.php";
# Передаем всю работу библиотеке Subsys_Templier_ApacheHandler.
$handler = new Subsys_Templier_ApacheHandler("Subsys_Templier_Smarty");
$handler->processRequest();
?>