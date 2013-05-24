<?php ## Скрипт отображения свойств узла
require_once 'unicode.inc';
require_once 'nodetypes.inc';
require_once 'domnodetitle.inc';
require_once 'print_properties.inc';
require_once 'path.inc';
require_once 'showref.inc';
require_once 'refs.inc';

if (!isset($_GET["xmlfile"])) $xmlfile='prog.xml';
else
    $xmlfile=$_GET["xmlfile"];
if (!$xmlfile)
    $xmlfile='prog.xml';

if (!isset($_GET["path"])) $path='/';
else
    $path=$_GET["path"];
while (strstr($path,'//')) //заменить все // на /
    $path=str_replace('//','/',$path);
$dom=new domDocument('1.0');
$dom->preserveWhiteSpace=false;
$dom->load($xmlfile);

$node=getNodeByPath($dom,$path);
$title="Свойства узла\r\n".domNodeTitle($node).
	"\r\n(путь:".utf8decode($path).")";
?>
<HTML>
<HEAD>
<link REL="stylesheet" TYPE="text/css" HREF="style.css">
<TITLE><?php echo $title?></TITLE>
</HEAD>
<BODY>
<H1><?php echo nl2br($title)?></H1>
<?php print_domNodeProperties($node);?>
<HR>
<H1>Содержание узла</H1>
<PRE>
<?php
$dom->formatOutput=true;
if ($node !== $dom)
    echo htmlspecialchars(utf8decode($dom->saveXML($node)));
else
    echo htmlspecialchars($dom->saveXML());
?>
</PRE>
</BODY>
</HEAD>
