<?php ## Использование оператора foreach для обхода списка узлов
      ##  класса NamedNodeMap
require_once 'unicode.inc';
$xml="<?xml version='1.0' encoding='".Encoding."'?>
<root attr1='1' attr2='2'
  ><child>1-й дочерний узел</child
  ><child>2-й дочерний узел</child
  ></root>";
$dom=new domDocument();
$dom->loadXML($xml);
$root=$dom->documentElement;
$namedNodeMap=$root->attributes;//получить список атрибутов root
echo "Всего атрибутов: $namedNodeMap->length\r\n";
foreach($namedNodeMap as $i => $attr) {
    echo "Aтрибут $i: ";
    echo utf8decode("$attr->nodeName='$attr->nodeValue'\r\n");
}
$attrname='attr2';
$attr2=$namedNodeMap->getNamedItem($attrname);
echo "Атрибут с именем $attrname :";
echo utf8decode("$attr2->nodeName='$attr->nodeValue'\r\n");
?>
