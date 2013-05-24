<?php ## Пример загрузки документа, конвертирования
      ##  и доступа к атрибутам
include 'unicode.inc';
$xml=XMLHead.
"<элемент атр1='1-й атрибут'/>";
$root_simplexml=simplexml_load_string($xml); //загруузка документа
//чтение атрибута 'атр1' корневого элемента
$attr1=$root_simplexml[utf8encode('атр1')];
echo 'атр1='.utf8decode($attr1)."\r\n";

//импортирование документа из SIMPLEXML в DOM
$root_dom=dom_import_simplexml($root_simplexml);
$domdocument=$root_dom->ownerDocument;
echo "Вывод документа в DOM:\r\n";
echo $domdocument->saveXML();

//добавление нового атрибута в DOM
$root_dom->setAttribute(utf8encode('атр2'),
			utf8encode('2-й атрибут'));

//импортирование документа из DOM в SIMPLEXML
$root1_simplexml=simplexml_import_dom($root_dom);
echo "Вывод документа в SIMPLEXML:\r\n";
echo $root1_simplexml->to_xml_string();
showattrs($root1_simplexml);//отображение атрибутов в SIMPLEXML


/**
 * Отобразить атрибуты элемента в SIMPLEXML.
 *
 * @param $element class simplexml_element
 */
function showattrs($element)
{
    echo "Значение атрибутов:\r\n";
    foreach($element->attributes() as $attrname => $attrvalue) {
	echo utf8decode("\t$attrname='$attrvalue'\r\n");
    }
}
