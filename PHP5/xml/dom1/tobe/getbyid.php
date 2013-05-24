<?php ## Пример выбора элемента по идентификатору
include 'unicode.inc';
$dom=new domDocument('1.0',Encoding);
$dom->load('Song.xml'); //загрудить песню с определением идентификатора id
$id2=$dom->getElementById(2);   //взять элемент с идентификатором id=2
echo utf8decode($dom->saveXML($id2))."\r\n";//отображить найденный элемент
?>
