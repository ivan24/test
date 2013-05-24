<?php ## Последовательный обход дочерних узлов
include 'unicode.inc';
$xml="
<root>
 <!-- comment -->
 <child1>text1</child1>
 <child2>text2</child2>
 <child1>text1</child1>
 <?php echo 'PHP'?>
</root>";

$sxml=simplexml_load_string($xml);//загрузка XML-документа
foreach($sxml as $nodename => $nodevalue) {
    echo "$nodename: $nodevalue\r\n";
}
?>
