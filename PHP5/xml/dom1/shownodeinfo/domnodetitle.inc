<?php ## Функция формирования общей информации об узле
/**
 * Сформировать строку общего текстовое представления узла
 *
 * @param domNode $domnode узел
 *
 * @return string строка описания узла
 */
function domNodeTitle($domnode)
{
    if (!$domnode) return 'null';
    $ret=nodeTypeToString($domnode->nodeType) .":\r\n";
    $nodeName=utf8decode($domnode->nodeName);
    $nodeValue=utf8decode($domnode->nodeValue);

    $descr='';
    switch ($domnode->nodeType) {
    case XML_DOCUMENT_NODE:	 //Документ
	$descr.= "<?xml ...?> ...<...>...<...>";
	break;
    case XML_ELEMENT_NODE:	//Элемент
	$descr.= "<$nodeName ...>...</$nodeName>";
	break;
    case XML_COMMENT_NODE:	//Комментарий
	$descr= "<!-- ... -->";
	break;
    case XML_DOCUMENT_TYPE_NODE://Описатель типа документа
	$descr= "<!DOCTYPE $nodeName [...]]>";
	break;
    case XML_PI_NODE:		//Команды приложения
	$descr= "<?$nodeName ...?>";
	break;
    case XML_ATTRIBUTE_NODE:	//атрибут
	$descr= "$nodeName=\"$nodeValue\"";
	break;
    case XML_CDATA_SECTION_NODE://Секция CDATA
	$descr= "<![CDATA[ ...]]>";
	break;
    case XML_ENTITY_REF_NODE:	//Ссылка на компоненту
	$descr= "&$nodeName";
	break;
    case XML_ENTITY_DECL_NODE:	//Описание компоненты
	$descr= "<!ENTITY $nodeName \"...\">";
	break;
    case XML_TEXT_NODE: //Текстовый узел
	$descr= "$nodeValue";
	break;
    default:	//Неизвестный узел
	$descr="имя: $nodeName\r\nзначение: $nodeValue";
    }
    $ret.="<B>".htmlspecialchars($descr).";</B>";

    return $ret;
}

