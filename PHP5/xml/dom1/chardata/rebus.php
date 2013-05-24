<?php ## Программа решения ребуса
require_once 'unicode.inc';
require_once 'rebus.class';
$rebus=new rebus();
$rebus->load($argv[1]);
$document=new domDocument('1.0',Encoding);
$answer=$document->createTextNode('');
$rebus->result($answer);
echo utf8decode($document->saveXML($answer));
?>
