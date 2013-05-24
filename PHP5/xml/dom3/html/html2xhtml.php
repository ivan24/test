<?php ## Программа html2xhtml загрузки HTML-документ
      ##  и отображения его в формате XML
$document=new domDocument();
$document->loadHTMLFile('html1.html');
$document->formatOutput=true;
echo $document->saveXML();
?>
