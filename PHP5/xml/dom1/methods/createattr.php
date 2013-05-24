<?php ## ѕример создани€ узла атрибута
require_once 'unicode.inc';
$domdocument=new domDocument('1.0',Encoding);   //ƒокумент

$tablenode=$domdocument->createElement('table');// орневой элемент
$domdocument->appendChild($tablenode);  //добавить к документу

$attrnode=$domdocument->createAttribute('width');//создать атрибут width
$tablenode->setAttributeNode($attrnode);//добавить его к элементу
$textnode=$domdocument->createTextNode('100%'); //создать узел значени€
$attrnode->appendChild($textnode); //присоединить его к атоибуту

$domdocument->formatOutput=true;
$tablexml=utf8decode($domdocument->saveXML($tablenode));
echo $tablexml; //вывести XHTML текст таблицы
?>
