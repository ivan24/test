<?php ## Загрузка XML-документа методом loadXML()
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
// построить дерево объектов по XML-документу
$domdocument->loadXML($xmldocument);
?>
