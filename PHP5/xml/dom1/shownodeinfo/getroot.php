<?php ## Функции доступа к корневому узлу и узлу DocType
/**
 * Найти корневой элемент
 *
 * @param domDocument $dom XML-документ
 *
 * @return domNode корневой элемент XML-документа
 */
function getroot($dom)
{
    $children=$dom->childNodes;
    foreach ($children as $child) {
	if ($child->nodeType==XML_ELEMENT_NODE)
	    return $child;
    }
    return NULL;
}

/**
 * Найти описатель DTD
 *
 * @param domDocument $dom XML-документ
 *
 * @return domNode корневой элемент XML-документа
 */
function getDTD($dom)
{
    $children=$dom->childNodes;
    foreach ($children as $child) {
	if ($child->nodeType==XML_DOCUMENT_TYPE_NODE)
	    return $child;
    }
    return NULL;
}
?>
