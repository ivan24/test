<?php ## Обход дочерних узлов с использованием свойств
      ## firstChild и nextSibling
require_once 'unicode.inc';
$xml="<?xml version='1.0' encoding='".Encoding."'?>
<root attr1='1' attr2='2'
  ><child>1-й дочерний узел</child
  ><child>2-й дочерний узел</child
  ></root>";
$dom=new domDocument();
$dom->loadXML($xml);
$root=$dom->documentElement;
echo "Всего дочерних узлов: {$root->childNodes->length}\r\n";
$i=0;
for ($child=$root->firstChild;$child;$child=$child->nextSibling) {
    echo "Узел $i: ";
    echo utf8decode("$child->nodeName='$child->nodeValue'\r\n");
    $i++;
}
?>
