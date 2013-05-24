<?php ## Пример обхода списка узлов с использованием ссылок
      ##  с одновременной корректировкой списка
$xml="<root><child0/><child1/><child2/><child3/></root>";
$dom=new domDocument();
$dom->loadXML($xml);
echo "Исходный документ: \r\n";echo $dom->saveXML();
$root=$dom->documentElement;
echo "\r\nОбход 1-го уровня с установкой aтрибута id\r\n";
$nodes='';$i=0;
for ($child=$root->firstChild; $child;) {
    $nextchild=$child->nextSibling;
    $nodes.=$dom->saveXML($child);
    $child->setAttribute('id',$i);
    if ($i==1)	{
	echo "Удаление элемента N$i:".$dom->saveXML($child)."\r\n";
	$root->removeChild($child);
    }
    $child=$nextchild;$i++;
}
echo "\r\nПройденные узлы: $nodes\r\n";
echo "\r\nИтоговый документ: \r\n";echo $dom->saveXML();
?>
