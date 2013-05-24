<?php ## Пример обхода списка узлов оператором foreach
      ##  с одновременной корректировкой списка
$xml="<root><child0/><child1/><child2/><child3/></root>";
$dom=new domDocument();
$dom->loadXML($xml);
echo "Исходный документ: \r\n";echo $dom->saveXML();
$root=$dom->documentElement;
$nodelist=$root->childNodes;    //список узлов 1-го уровня
echo "\r\nОбход 1-го уровня с установкой aтрибута id\r\n";
$nodes='';
foreach ($nodelist as $i => $child) {
    $nodes.=$dom->saveXML($child);
    $child=$nodelist->item($i);
    $child->setAttribute('id',$i);
    if ($i==1) {
	echo "Удаление элемента N$i:".$dom->saveXML($child)."\r\n";
	$root->removeChild($child);
    }
}
echo "\r\nПройденные узлы: $nodes\r\n";
echo "\r\nИтоговый документ: \r\n";echo $dom->saveXML();
?>
