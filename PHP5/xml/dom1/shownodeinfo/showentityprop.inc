<?php ## Отображение свойств класса domEntity
/**
 * Отобразить свойства узла класса domEntity в формате HTML
 *
 * @param domEntity $domuntity	узел XML-документа
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function showEntityDeclProperties($domentity)
{?>

    ><TR
    ><TD>version (Версия):</TD
    ><TD><?php echo $domentity->version?></TD
    ></TR

    ><TR
    ><TD>encoding (Кодировка):</TD
    ><TD><?php echo $domentity->encoding?></TD
    ></TR

    ><TR
    ><TD>actualEncoding Действительная кодировка():</TD
    ><TD><?php echo $domentity->actualEncoding?></TD
    ></TR

    ><TR
    ><TD>notationName(Приложение):</TD
    ><TD><?php echo $domentity->notationName?></TD
    ></TR

    ><TR
    ><TD>publicId ():</TD
    ><TD><?php echo $domentity->publicId?></TD
    ></TR

    ><TR
    ><TD>systemId ():</TD
    ><TD><?php echo $domentity->systemId?></TD
    ></TR

    <?php
}
?>
