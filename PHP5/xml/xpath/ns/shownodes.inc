<?php ## –екурсивна€ функци€ shownodes() формировани€
      ##  HTML-кода DOM-узлов
include 'nodestate.inc';
include 'showattributes.inc';
include 'textopenclose.inc';
/**
 *  –екурсивно сформировать HTML-представление DOM-узлов
 *
 *  @param domNode $node отображаемый узел
 *  @param int $level уровень узла в дереве
 *
 *  @return HTML-код поддерева узла
 */
function shownodes($node,$level)
{
    global $levels;
    $ret='';
    //определить тип узла - обычный, контекстный, в xpath
    list($pre,$post)=nodeState($node);
    $div=false;
    if ($level!=0 &&
	(get_parent_class($node) != 'domcharacterdata' ||
	$node->length > 80))
	$div=true;
    if ($div)
	//заключить в DIV дл€ обеспечени€ сдвига по горизонтали
	$ret.="<DIV>";
    if ($node->nodeType==XML_ELEMENT_NODE ) { //Ёлемент ?
	$ret.=$pre.'&lt;'.$node->tagName.$post; //открывающий тег
	$ret.=showattributes($node); //отобразить узлы атрибутов
	if ($node->hasChildNodes()) { //есть потомки
	    $ret.=$pre.'&gt;'.$post;//конец открывающего тега
	    if ($levels <0 || $level < $levels)
		//показать каждого потомка
		for($child=$node->firstChild;$child;
		    $child=$child->nextSibling)
		    $ret.=shownodes($child,$level+1);
	    //закрывающий тег
	    $ret.=$pre.'&lt;/'.$node->tagName.'&gt;'.$post;
	} else
	    $ret.=$pre.'/&gt;'.$post; //простой тег
    } else {
	$ret.=$pre;
	if ($node->nodeType==XML_PI_NODE ) { //ProcessingInstruction?
	    $ret.=htmlspecialchars("<?$node->target $node->nodeValue?>");
	    $ret.="<BR/>";
	} else {   //текстовые элементы
	    //открывающие и закрывающие последовательности
	    list($open,$close)=textopenclose($node);
	    //вывести текстовый элемент
	    $ret.=htmlspecialchars($open.$node->data.$close);
	}
	$ret.=$post;
    }
    if ($div)
	$ret.="</DIV>\r\n";
    return $ret;
}
?>
