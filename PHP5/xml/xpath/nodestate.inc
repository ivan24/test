<?php ## ‘ункци€ nodeState() определени€ состо€ни€ узла
/**
 *  ќпределить тип узла - обычный, контекстный, в xpath.
 *
 *  @param domNode $node отображаемый узел
 *
 *  @return array массив строк обрамл€ющих HTML-тегов.
 *  0-й элемент - откравающий тег.
 *  1-й элемент - закравающий тег.
 */
function nodeState($node)
{
    global $list,$context;  //список узлов в Xpath и контекстгый узел
    $count=0;	    //число вхождений узла в Xpath
    for ($n=0;$n<$list->length;$n++) {
	$node1=$list->item($n);
	if ($node===$node1)	//посчитать число вхождений
	    $count++;
    }
    if ($count >0) { //узел есть в Xpath
	$pre="<SPAN CLASS='xpathNode'>";    //тип xpathNode
	$post="</SPAN>";
    } else {
	$pre='';$post=''; //иначе обычный узел
    }
    if ($node === $context) {	    //контекстный узел
	$pre.="<SPAN CLASS='contextNode'>"; //добавить тип contextNode
	$post="</SPAN>$post";
    }
    return Array($pre,$post);
}
?>
