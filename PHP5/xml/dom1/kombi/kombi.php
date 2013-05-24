<?php ## Комбинированный вариант формирования DOM-дерева
require_once 'unicode.inc';
/**
 * Создать объект класса domDocument на основе XML-документа,
 * сформированного скриптом script1.php
 *
 * @return  экземпляр класса domDocument
 */
function loadprogram()
{
    $domdocument=new domDocument('1.0',Encoding);
    ob_start();     //включить буферизацию вывода
    include_once 'script1.php';  //заполнение буфера XML-документом
    //построить DOM-дерево на основе содержимого буфера
    $domdocument->loadXML(ob_get_contents());
    ob_end_clean(); //очистить буфер и выключить буферизацию
    return $domdocument;
}

$domdocument=loadprogram();   //Сформировать XML-документ
echo $domdocument->saveXML(); //Отобразить его
?>
