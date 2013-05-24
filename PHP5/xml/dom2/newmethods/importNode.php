<?php ## ѕример использовани€ метода importNode класса domDocument
require_once 'unicode.inc';

$html=XMLHead.'
<html xmlns="http://www.w3.org/1999/xhtml"
><head><title>HTML-страница</title></head
><body><form><input name="bookname"/></form></body
></html>';
$domhtml=new domDocument('1.0','WINDOWS-1251');
$domhtml->loadXML($html);
$form=$domhtml->getElementsbyTagName('form')->item(0);

$bookxml=XMLHead.'
<books xmlns="http:..."><book/><book/></books>';
$book=new domDocument('1.0','WINDOWS-1251');
$book->loadXML($bookxml);

$bookform=$book->importNode($form,true);
$book->documentElement->appendChild($bookform);
$book->formatOutput=true;
echo $book->saveXML();
?>
