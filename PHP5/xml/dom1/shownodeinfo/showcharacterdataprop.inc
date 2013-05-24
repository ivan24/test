<?php ## Отображение свойств класса domCharacterData
/**
 * Отобразить свойства узла класса domCharacterData в формате HTML
 *
 * @param domCharacterData $domelement узел класса
 *		domText, domCDATASection или domComment
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function showCharacterDataProperties($domcharacterdata)
{?>
    ><TR
    ><TD>data (Данные):</TD
    ><TD><?php echo utf8decode($domcharacterdata->data)?></TD
    ></TR
    ><TR
    ><TD>length (Длина):</TD
    ><TD><?php echo $domcharacterdata->length?></TD
    ></TR
    <?php
}
?>
