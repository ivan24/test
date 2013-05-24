<?php ## ќбход дочерних узлов в обратном направлении
      ##  с использованием свойств firstChild и nextSibling
require_once 'unicode.inc';
$xml="<?xml version='1.0' encoding='".Encoding."'?>
<root attr1='1' attr2='2'
  ><child>1-й дочерний узел</child
  ><child>2-й дочерний узел</child
  ></root>";
$dom=new domDocument();
$dom->loadXML($xml);
$root=$dom->documentElement;
echo "¬сего дочерних узлов: {$root->childNodes->length}\r\n";
for ($child=$root->lastChild;$child;$child=$child->previousSibling) {
    echo utf8decode("$child->nodeName='$child->nodeValue'\r\n");
}
?>
