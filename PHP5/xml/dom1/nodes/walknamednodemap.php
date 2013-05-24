<?php ## »спользовани€ последовательного и пр€мого доступа
      ##  к узлам списка класса NamedNodeMap
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
echo "¬сего атрибутов: $namedNodeMap->length\r\n";
for ($i=0;$i<$namedNodeMap->length;$i++) {
    $attr=$namedNodeMap->item($i);//i-й атрибут
    echo "јтрибут $i: ";
    echo utf8decode("$attr->nodeName='$attr->nodeValue'\r\n");
}
$attrname='attr2';
$attr2=$namedNodeMap->getNamedItem($attrname);
echo "јтрибут с именем $attrname :";
echo utf8decode("$attr2->nodeName='$attr->nodeValue'\r\n");
?>
