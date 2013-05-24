<?php ## Функция определения глубины XML-дерева
/**
 *  Определить глубину XML-дерева.
 *
 *  @param domElement $Element корневой элемент дерева
 *			       (при первом вызове)
 */
function countDepth($Element)
{
    $maxChildDepth=0;//максимальная глубина дочерних элементов
    if ($Element->hasChildNodes()) { //есть дочерние элементы
	//пройтись по дочерним элементам
	for ($child=$Element->firstChild;$child;
	     $child=$child->nextSibling) {
	    //определить максимальную глубину
	    $childDepth=countDepth($child);
	    if ($maxChildDepth < $childDepth)
		$maxChildDepth = $childDepth;
	}
    }
    return $maxChildDepth+1;//вернуть текущий максимальные уровень
}
?>
