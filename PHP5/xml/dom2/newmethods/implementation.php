<?php ## Создание HTML-документа методами класса domImplementation
include 'unicode.inc';
$htmlNS='http://www.w3.org/1999/xhtml'; //Namespace для XHTML
$publicId="-//W3C//DTD XHTML 1.0 Strict//EN";
$systemId="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd";

$domimpl=new domImplementation(); //создать объект
$dtype=$domimpl->createDocumentType('html',$publicId,$systemId);
$dom=$domimpl->createDocument($htmlNS,'html',$dtype);
$dom->encoding=Encoding;
$dom->formatOutput=true;

$html=$dom->documentElement;
$head=$dom->createElementNS($htmlNS,'head');
$title=$dom->createElementNS($htmlNS,'title');
$title->appendChild($dom->createTextNode('test'));
$head->appendChild($title);

$body=$dom->createElementNS($htmlNS,'body');
$body->appendChild($dom->createTextNode(utf8encode('Проверка')));

$html->appendChild($body);
echo $dom->saveXML();
?>
