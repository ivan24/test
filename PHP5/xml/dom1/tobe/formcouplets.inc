<?php ## Функция  formcouplets() добавления рефрена к куплету
/**
 * Доформировать куплеты, добавав к ним рефрен.
 * Функция обходит куплеты, добавляя к ним рефрен.
 *
 * @param domElement $coupluts элемент куплеты (куплеты песни)
 * @param domElement $refrain рефрен песни
 */
//доформировать куплеты добавив в них рефрен
function formсouplets($couplets,$refrain) {
    for($couplet=$couplets->firstChild; //1-й дочерний узел
	$couplet;   //пока есть дочерние узлы
	$couplet=$couplet->nextSibling) { //взять следующий
	//добавить рефрен к каждому куплету
	$couplet->appendChild($refrain->cloneNode(true));
    }
}
?>
