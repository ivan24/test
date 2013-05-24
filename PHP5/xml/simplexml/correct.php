<?php ## Пример корректировки текстовых узлов документа
include 'unicode.inc';
$xml="<?xml version='1.0' encoding='".Encoding."'?>
<root>
 <child1>текст</child1>
 <child2>текст</child2>
 <child1>текст</child1>
</root>";

//Загрузка документа
$sxml=simplexml_load_string($xml);//загрузка XML-документа

//Корректировка элемента child2
$sxml->child2.=utf8encode("+добавленный текст");
$sxml->child2['add']=utf8encode('добавленный атрибут');

//Корректировка элементов child1
$sxml->child1[0].=utf8encode("+добавленный текст");
$sxml->child1[1].=utf8encode("+добавленный текст");
$sxml->child1[0]['add']=utf8encode('добавленный атрибут');
$sxml->child1[1]['add']=utf8encode('добавленный атрибут');

//Вывод документа
echo $sxml->to_xml_string();
?>
