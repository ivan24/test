<?php ## Выбор элементов по запросу XPATH с указанным
      ##  пространством имен
include 'unicode.inc';
$xml="<?xml version='1.0' encoding='".Encoding."'?>
<root xmlns:a='http://...ns1' xmlns='http://...ns2'>
 <a:child1>текст1</a:child1>
 <child2>текст2</child2>
 <child1>текст3</child1>
 <child xmlns='http://...ns1'>
     <child1>текст4</child1>
     <child1>текст5</child1>
 </child>
</root>";

//Загрузка документа
$sxml=simplexml_load_string($xml);//загрузка XML-документа
//Связывание префикса A запроса с областью имен http://...ns1
$sxml->register_ns('A','http://...ns1');
//Выбор всех элементов с именем child1 в области имен http://...ns1
$list=$sxml->xsearch('//A:child1');

//вывод значения найденных элементов
foreach($list as $element)
    echo utf8decode("$element\r\n");
?>
