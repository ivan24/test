<?php ## Функция вывода строк таблицы
/**
 *  Вывести строки таблицы модулей. Функция вызывается рекурсивно.
 *
 *  @param domElement $element отображаемый элемент
 *  @param int $level уровень модуля
 */
function formRow($element,$level)
{ //вывести строки таблицы
    global $depth,$table;
    $name=$element->getAttribute('name');   //полноя имя модуля
    $feature=$element->tagName;     //имя модуля
    //вывести левую часть строки
    $table->leftRow($level,$depth,$name,$feature);
    //вывести правую часть строки
    $table->rightRow($feature);
    //вывести строки всех дочерних элементов
    for($child=$element->firstChild;$child;$child=$child->nextSibling)
	formRow($child,$level+1);
}
?>
