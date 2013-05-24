<?php ## Два способа создания экземпляра класса DOM
require_once 'unicode.inc';
$domdocument=new domDocument('1.0',Encoding);   //Документ

$element1=$domdocument->createElement('body');
$element2=new domElement('body');
?>
