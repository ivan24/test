<?php ## »спользование оператора foreach дл€ обхода
      ##  списка узлов класса NodeList
require_once 'unicode.inc';
$xml="<?xml version='1.0' encoding='".Encoding."'?>
<root attr1='1' attr2='2'
  ><child>1-й дочерний узел</child
  ><child>2-й дочерний узел</child
  ></root>";
$dom=new domDocument();
$dom->loadXML($xml);
$root=$dom->documentElement;
$nodeList=$root->childNodes;//получить список дочерних узлов узла node
echo "¬сего дочерних узлов: $nodeList->length\r\n";
foreach ($nodeList as $i => $child) {
    $child=$nodeList->item($i);//i-й дочерний узел
    echo "”зел $i: ";
    echo utf8decode("$child->nodeName='$child->nodeValue'\r\n");
}
?>
