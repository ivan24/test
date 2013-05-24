<?php ## Отображение свойств класса domProceccingInstruction
/**
 * Отобразить свойства узла класса domProceccingInstruction
 * в формате HTML
 *
 * @param domProceccingInstruction $domproceccingInstruction
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function showPIProperties($domprocessinginstruction)
{?>

    ><TR
    ><TD>target (Приложение):</TD
    ><TD><?php echo utf8decode($domprocessinginstruction->target)?></TD
    ></TR

    ><TR
    ><TD>data(Код):</TD
    ><TD><?php echo utf8decode($domprocessinginstruction->data)?></TD
    ></TR

<?php
}
