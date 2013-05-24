<?php ## Отображение свойств класса domDocument
/**
 * Отобразить свойства узла класса domDocument в формате HTML
 *
 * @param domDocument $domdocument узел XML-документа
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function showDocumentProperties($domdocument)
{?>

    ><TR
    ><TD>documentURI (Адрес):</TD
    ><TD><?php echo $domdocument->documentURI?></TD
    ></TR

    ><TR
    ><TD>version (версия):</TD
    ><TD><?php echo $domdocument->version?></TD
    ></TR

    ><TR
    ><TD>encoding (кодировка):</TD
    ><TD><?php echo $domdocument->encoding?></TD
    ></TR

    ><TR
    ><TD>ActualEncoding (Текущая кодировка)):</TD
    ><TD><?php echo $domdocument->actualEncoding?></TD
    ></TR

    ><TR
    ><TD>DTD</TD
    ><TD><?php
    showref('/'.getDTDnumber($domdocument),$domdocument->doctype)
    ?></TD
    ></TR

    ><TR
    ><TD>Root</TD><TD><?php
    showref('/'.getrootnumber($domdocument),$domdocument->documentElement)
    ?></TD
    ></TR

    ><TR
    ><TD>standalone (Автономный):</TD
    ><TD><?php echo ($domdocument->standalone?'Да':'Нет')?></TD
    ></TR

    ><TR
    ><TD>formatOutput(Форматировать):</TD
    ><TD><?php echo ($domdocument->formatOutput?'Да':'Нет')?></TD
    ></TR

    ><TR
    ><TD>validateOnParse(Проверять при анализе):</TD
    ><TD><?php echo ($domdocument->validateOnParse?'Да':'Нет')?></TD
    ></TR

    ><TR
    ><TD>resolveExternals(Разрешать внешние ссылки):</TD
    ><TD><?php echo ($domdocument->resolveExternals?'Да':'Нет')?></TD
    ></TR

    ><TR
    ><TD>preserveWhiteSpace(Подавлять незначащие пробелы):</TD
    ><TD><?php echo ($domdocument->preserveWhiteSpace?'Да':'Нет')?></TD
    ></TR

    ><TR
    ><TD>substituteEntities(Подставлять компоненты):</TD
    ><TD><?php echo ($domdocument->substituteEntities?'Да':'Нет')?></TD
    ></TR
    <?php
}

/**
 * Найти номер корневого элемент
 *
 * @param domDocument $domdocument узел XML-документа
 *
 * @return int номер корневого элемента в списке дочерних элементов
 */
function getrootnumber($domdocument)
{
    $children=$domdocument->childNodes;
    for ($ret=0;$ret<$children->length;$ret++) {
	$child=$children->item($ret);
	if ($child->nodeType==XML_ELEMENT_NODE)
	    break;
    }
    $ret++; //адрес начинается с 1-цы => +1
    return $ret;
}

/**
 * Найти номер описателя DTD
 *
 * @param domDocument $domdocument узел XML-документа
 *
 * @return int номер описателя DTD в списке дочерних элементов
 */
function getDTDnumber($domdocument)
{
    $children=$domdocument->childNodes;
    for ($ret=0;$ret<$children->length;$ret++) {
	$child=$children->item($ret);
	if ($child->nodeType==XML_DOCUMENT_TYPE_NODE)
	    break;
    }
    $ret++; //адрес начинается с 1-цы => +1
    return $ret;
}
?>
