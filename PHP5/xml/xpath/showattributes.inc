<?php ## Функция showattributes() отображения атрибутов
/**
 *  Сформировать HTML-код атрибутов элемента.
 *
 *  @param domNode $node отображаемый элемент
 *
 *  @return  HTML-код атрибутов элемента
 */
function showattributes($node)
{
    $ret='';
    for ($i=0;$i<$node->attributes->length;$i++){//по всем атрибутам
	$attrnode=$node->attributes->item($i); //узел атрибута
	$attrname=$attrnode->nodeName; //имя атрибута
	//определить тип узла атрибута
	list($pre,$post)=nodeState($attrnode);
	//сформировать HTML-код
	$ret.="$pre $attrnode->nodeName='".
		    $node->getAttribute($attrname)."'$post";
    }
    return $ret;
}
?>
