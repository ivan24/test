<?php ## Программа html2html загрузки HTML-документ
      ##  и отображения его в формате HTML
$document=new domDocument();
$document->loadHTMLFile('html1.html');
$document->formatOutput=true;
echo $document->saveHTML();
?>
