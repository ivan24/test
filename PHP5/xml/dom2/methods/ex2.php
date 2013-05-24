<?php ## Пример добавления атрибута с областью имен корневой элемент
require_once 'unicode.inc';
require_once 'controls.inc';
$document=new domDocument('1.0',Encoding);
$root=$document->createElementNS($book,'book:book');
//добавить атрибут theme, принадлежащий области имен book
$root->setAttributeNS($phpns,"phpns:theme",'php-controls');
$root->setAttributeNS($jsns,"jsns:theme",'js-controls');
$document->appendChild($root);//корневой элемент book
foreach($controls as $controlname => $sections) {
    //для всех описаний управляющих структур
    $tagname='book:'.$controlname; //имя структуры в области имен книги
    $control=$document->createElementNS($book,$tagname);
    $root->appendChild($control); //добавить заголовок описания
    foreach ($sections as $lang => $section){ //для каждой секции описания
	foreach ($section as $name => $text){ //выделить секцию и описание
	    $qname="$lang:$name"; //квалифицированное имя
	    $ns=$$lang; //область имен
	    //создать элемент и добавить в него текст
	    $element=$document->createElementNS($ns,$qname);
	    $text=utf8encode($text);
	    $element->appendChild($document->createTextNode($text));
	    $control->appendChild($element);
	}
    }
}
$document->formatOutput=true;
echo $document->saveXML(); //вывести полученный документ
?>

