<?php ## Скрипт showxpath.php отображения результатов запроса
      ##  с поддержкой областей имен
$xmlfile=$_GET['xmlfile'];      //имя XML-файла
$levels=$_GET['levels']-1;      //число отображаемых уровней
$contextpath=$_GET['contextpath'];      //адрес контекстного узла
$xpath=stripslashes($_GET['xpath']);          //запрос XPATH

include 'shownodes.inc';
include 'unicode.inc';

$document=new domDocument();
$document->preserveWhiteSpace=false;
$document->formatOutput=true;
$document->load($xmlfile);      //загрузить документ

if (!$contextpath)      //не задан контекстный узел
    $contextpath='/';   //=> корневой

//создать переменную класса domXpath для документа
$domxpath=new domXpath($document);
//Зарегистрировать области имен
include 'registerns.inc';
$nstable=registerns($domxpath);

//найти контекстный узел (1-й элемент массива)
$context=@$domxpath->query(utf8encode($contextpath));
if (!$context || $context->length == 0) {
    $error="Неверный контекстный узел, принят узел корневой узел /";
    $context=$domxpath->query('/');
}
$context=$context->item(0);
//найти узлы, удовлетворяющие запросу
$list=$domxpath->query(utf8encode($xpath),$context);
//сформировать HTML-документ?>
<HTML>
<HEAD>
<link REL="stylesheet" TYPE="text/css" HREF="style.css"></LINK>
<TITLE>Результат выполнения запроса <?php echo $xpath?>
от узла <?php echo $contextpath?>
</TITLE>
</HEAD>
<BODY>
<span CLASS='error'><?php echo @$error?></span>
<?php echo $nstable?>
<TABLE ALIGN=center
><TR><TH>Файл:</TH><TD><?php echo $xmlfile?></TD></TR
><TR><TH>Узел (контекст):</TH><TD><?php echo $contextpath?></TD></TR
><TR><TH>Запрос:</TH><TD><?php echo $xpath?></TD></TR
></TABLE>
<HR WIDTH=50%>
<?php
//сформировать дерево с выделенными узлами
$ret='';
for($child=$document->firstChild;$child;
    $child=$child->nextSibling){ //пройтись по первому уровню
    if ($child->nodeType==XML_DOCUMENT_TYPE_NODE) continue;
    $ret.=shownodes($child,0);
}
echo utf8decode($ret);  //отобраэить полученный результат
?>
</BODY>
</HTML>
