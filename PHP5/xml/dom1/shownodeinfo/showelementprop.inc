<?php ## Отображение свойств класса domElement
/**
 * Отобразить свойства узла класса domElement в формате HTML.
 *
 * @param domElement $domelement узел элемента XML-документа
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function showElementProperties($domelement)
{?>

    ><TR
    ><TD>tagName (Имя):</TD
    ><TD><?php echo utf8decode($domelement->tagName)?></TD
    ></TR

    ><TR
    ><TD>schemaTypeInfo (Тип схемы):</TD
    ><TD><?php echo $domelement->schemaTypeInfo?></TD
    ></TR

<?php
}
?>
