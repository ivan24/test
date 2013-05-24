<?php ## Использование операции присвоения вместо клонирования узла
function formRefrain($Refrain)
{
    $line4=$Refrain->firstChild;   //$line4 указывает на 1-ю строку
    $line3=$line4->cloneNode(true); //$line3 указывает на 1-ю строку
    $line4=$Refrain->appendChild($line4);//1-я строка перемещается в конец
}
?>
