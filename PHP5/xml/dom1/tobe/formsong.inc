<?php ## Функция formsong() формирования полного текста песни
/**
 * Сформировать полный текст песни.
 * Функция берет первую строку и дважды добавляет ее в конец куплета.
 *
 * @param domElement $song корневой элемент песни
 * @param domElement $copulets куплеты песни
 * @param domElement $Refrain припев песни
 */
function formsong($song,$couplets,$Refrain)
{
    global $songdoc;
    //для всех блоков шаблона (куплетов и припевов)
    for($Block=$song->firstChild;$Block;$Block=$nextBlock) {
	if ($Block->tagName==utf8encode('Куплет')) {  //Куплет?
	    // найти куплет из заготовки с номером id
	    $number=$Block->getAttribute('id');
	    $block=$couplets->childNodes->item($number)->cloneNode(true);
	} else {
	    //припев - запомнить в block
	    $block=$Refrain->cloneNode(true);
	}
	$attrs=$Block->attributes;
	for($i=0;$i<$attrs->length;$i++) {
	    //Переписать атрибуты из тега шаблона в заготовку
	    $attr=$attrs->item($i);
	    $name=$attr->name;
	    $value=$attr->value;
	    $block->setAttribute($name,$value);
	}
	$nextBlock=$Block->nextSibling;
	$song->replaceChild($block,$Block); //заменить шаблон на заготовку
    }
}
?>
