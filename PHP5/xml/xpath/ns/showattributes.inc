<?php ## Функция showattributes() отображения атрибутов
      ##  и префикса
/**
 *  Сформировать HTML-код атрибутов элемента и описания префиксов.
 *
 *  @param domNode $node отображаемый элемент
 *
 *  @return  HTML-код атрибутов элемента и описания префиксов
 */
function showattributes($node)
{
    $ret='';
    if (($namespace=$node->namespaceURI) != null) {
	//элемент имеет namespace
	//описание включить в класс namespace
	$ret.="<SPAN CLASS=namespace>";
	$namespace='...'.strrchr($namespace,'/');//укоротить описание
	if ($prefix=$node->prefix)  //префикс указан?
	    $ret.=" xmlns:$prefix='$namespace' ";
	else        //default namespace
	    $ret.=" xmlns='$namespace' ";
	$ret.="</SPAN>";
    }
    for ($i=0;$i<$node->attributes->length;$i++){//по всем атрибутам
	$attrnode=$node->attributes->item($i); //узел атрибута
	$attrname=$attrnode->nodeName; //имя атрибута
	//определить тип узла атрибута
	list($pre,$post)=nodeState($attrnode);
	$ret.="$pre $attrnode->nodeName='".
	    $node->getAttribute($attrname)."'$post";   //сформировать
    }
    return $ret;
}
?>
