<?php ## Добавление дополнительных описателей областей имен к элементу
require_once 'unicode.inc';
require_once 'controls.inc';
$document=new domDocument('1.0',Encoding);
$root=$document->createElementNS($book,'book:book');
addxmlnsattr($root,'jsns',$jsns);
addxmlnsattr($root,'phpns',$phpns);
$document->appendChild($root); //корневой элемент book
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


/**
 * Добавить описатель xmlns:$prefix=$ns в элемент
 *
 * @param domElement $element корректируемый элемент
 * @param string $prefix имя префикса
 * @param string $ns имя обдасти действия
 */
function addxmlnsattr($element,$prefix,$ns)
{
    //уникальное (надеюсь) имя атрибута в области имен $ns
    $uniqname='_uniqattrs';
    //добавить атрибут
    $element->setAttributeNS($ns,"$prefix:$uniqname",'');
    // (автоматически добавляется описатель xmlns:$prefix=$ns)
    $element->removeAttributeNS($ns,$uniqname); //удалить атрибут
    // ( описатель xmlns:$prefix=$ns остается)
}
?>
