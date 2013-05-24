<?php ## Пример обхода узлов 1-го уровня
$xml="<root><child1/><child2/></root>";
$dom=new domDocument();
$dom->loadXML($xml);
echo "Исходный документ: \r\n";echo $dom->saveXML();
$root=$dom->documentElement;
$nodelist=$root->childNodes;    //список узлов 1-го уровня
$child0=$dom->createElement('child0');
$root->insertBefore($child0,$root->firstChild);
echo "\r\nСкорректированный документ: \r\n";echo $dom->saveXML();
echo "\r\nДобавление атрибутов к узлам списка:\r\n";
for ($i=0;$i<$nodelist->length;$i++) {
    $child=$nodelist->item($i);
    $child->setAttribute('id',$i);
}
echo "Итоговый документ: \r\n";echo $dom->saveXML();
?>
