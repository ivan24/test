<?php ## Обход узлов списка класса NodeList
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
echo "Всего дочерних узлов: $nodeList->length\r\n";
for ($i=0;$i<$nodeList->length;$i++) {
    $child=$nodeList->item($i);//i-й дочерний узел
    echo "Узел $i: ";
    echo utf8decode("$child->nodeName='$child->nodeValue'\r\n");
}
?>
