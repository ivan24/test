<?php ## Программа testsaveXML.php вывода XML-документа с отступами
      ## и сменой кодировки
require_once "unicode.inc";
$domdocument=new domDocument('1.0',Encoding);
$xmldocument=XMLHead.
"<HTML>
<HEAD>
<TITLE>Пример XML-документа</TITLE>
</HEAD>
<BODY>
<H1>Пример XML-документа </H1>
<IMG SRC='picture1.gif' ALT='картинка 1' />
<IMG SRC='picture2.gif' ALT='картинка 2' />
</BODY>
</HTML>
";
$domdocument->preserveWhiteSpace=false; //подавлять незначащие пробелы
$domdocument->loadXML($xmldocument); // построить дерево объектов по XML-документу

echo "Вывод документа в кодировке KOI8-R с отступами:\r\n";
$domdocument->formatOutput=true;
$domdocument->encoding='KOI8-R';
echo $domdocument->saveXML(); //вывести документ с отступами
echo "\r\n";

echo "Вывод документа в кодировке WINDOWS-1251 одной строкой:\r\n";
$domdocument->encoding='WINDOWS-1251';
$domdocument->formatOutput=false;
echo $domdocument->saveXML();
?>
