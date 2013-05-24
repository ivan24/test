<?php ## Формирование припева функцией formRefrain()
/**
 * Сформировать куплет песни.
 * Функция берет первую строку и дважды добавляет ее в конец куплета.
 *
 * @param domElement $Refrain заготовка куплета песни
 */
function formRefrain($Refrain)
{
    $line4=$Refrain->firstChild->cloneNode(true);//$line4 хранит копию 1-й
    $line3=$line4->cloneNode(true); //$line3 хранит копию 4-й и 1-й строки
    $line4=$Refrain->appendChild($line4);   //вставить 4-ю  строку
    $line3=$Refrain->insertBefore($line3,$line4);//вставить 4-ю  строку
}
?>
