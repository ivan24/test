<?php ## Скрипт exslt.php
$domxsl=new domDocument();
$domxsl->load($argv[1]);//загрузить XSL-файл

$domxml=new domDocument();
$domxml->substituteEntities=true;      //произвести подстановки
$domxml->preserveWhiteSpace=false;      //убрать разделители
$domxml->load($argv[2]); //загрузить XML-файл

$xsl=new xsltProcessor();//создать XSLT-процессор
if (!$xsl->hasExsltSupport()) exit;

@$xsl->importStylesheet($domxsl); //оттранслировать XSLT-документ

echo $xsl->transformtoXML($domxml); //выполнить трансформацию
?>


