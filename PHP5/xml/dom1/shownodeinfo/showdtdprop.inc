<?php ## Отображение свойств класса domDocumentType
/**
 * Отобразить свойства узла класса domDocumentType в формате HTML
 *
 * @param domDocumentType $domdocumenttype узел DTD
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function showDTDProperties($domdocumenttype)
{?>

    ><TR
    ><TD>name (Имя):</TD
    ><TD><?php echo utf8decode($domdocumenttype->name)?></TD
    ></TR

    ><TR
    ><TD>publicId (общий идентификатор):</TD
    ><TD><?php echo utf8decode($domdocumenttype->publicId)?></TD
    ></TR

    ><TR
    ><TD>systemId (системный идентификатор):</TD
    ><TD><?php echo utf8decode($domdocumenttype->systemId)?></TD
    ></TR

    ><TR
    ><TD>entities (Компоненты):</TD
    ><TD><?php
    $entities=$domdocumenttype->entities;
    for ($i=0;$i<$entities->length;$i++) {
	echo utf8decode($entities->item($i)->nodeName).' ';
    }
    ?></TD
    ></TR

    ><TR
    ><TD>notations (приложения):</TD
    ><TD><?php
    $notations=$domdocumenttype->notations;
    for ($i=0;$i<$notations->length;$i++) {
	$notationsnode=$notations->item($i);
	$notationname=$notationsnode->nodeName;
	echo utf8decode("$notationname ");
    }
    ?></TD
    ></TR

    ><TR
    ><TD>internalSubset(Содержание):</TD
    ><TD><?php
    echo utf8decode(htmlspecialchars($domdocumenttype->internalSubset))
    ?></TD
    ></TR

    <?php
}
?>
