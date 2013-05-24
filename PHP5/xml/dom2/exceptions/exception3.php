<?php ## Пример загрузки некорректного XML-документа методом loadXML()
$xml="<root><child11/><child2/></root1>";
$dom=new domDocument();
$ret=$dom->loadXML($xml);
echo $dom->saveXML();
