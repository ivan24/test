<?php ## Отображение свойств класса domText
/**
 * Отобразить свойства узла класса domText в формате HTML
 *
 * @param domText $domtext текстовый узел  XML-документа
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function showTextProperties($domtext)
{?>
    ><TR
    ><TD>wholeText (Весь текст):</TD
    ><TD><?php echo utf8decode($domtext->wholeText)?></TD
    ></TR
<?php
}


