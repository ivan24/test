<?php ## Выбор элементов по запросу XPATH
include 'unicode.inc';
$xml="<?xml version='1.0' encoding='".Encoding."'?>
<root>
 <child1>текст1</child1>
 <child2>текст2</child2>
 <child1>текст3</child1>
 <child>
     <child1>текст4</child1>
     <child1>текст5</child1>
 </child>
</root>";

//Загрузка документа
$sxml=simplexml_load_string($xml);//загрузка XML-документа
//Выбор всех элементов с именем child1
$list=$sxml->xsearch('//child1');

//вывод значения найденных элементов
foreach($list as $element)
    echo utf8decode("$element\r\n");
?>
