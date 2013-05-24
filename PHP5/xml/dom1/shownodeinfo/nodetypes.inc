<?php ## Файл nodetypes.inc - описание типов узлов
/**
 * Массив соответствия номера узла его типу
 */
$nodeTypeNames=Array(
    XML_ELEMENT_NODE	   =>  "XML_ELEMENT_NODE",
    XML_ATTRIBUTE_NODE	   =>  "XML_ATTRIBUTE_NODE",
    XML_TEXT_NODE	   =>  "XML_TEXT_NODE",
    XML_CDATA_SECTION_NODE =>  "XML_CDATA_SECTION_NODE",
    XML_ENTITY_REF_NODE    =>  "XML_ENTITY_REF_NODE",
    XML_ENTITY_NODE	   =>  "XML_ENTITY_NODE",
    XML_PI_NODE 	   =>  "XML_PI_NODE",
    XML_COMMENT_NODE	   =>  "XML_COMMENT_NODE",
    XML_DOCUMENT_NODE	   =>  "XML_DOCUMENT_NODE",
    XML_DOCUMENT_TYPE_NODE =>  "XML_DOCUMENT_TYPE_NODE",
    XML_DOCUMENT_FRAG_NODE =>  "XML_DOCUMENT_FRAG_NODE",
    XML_ENTITY_DECL_NODE   =>  "XML_ENTITY_DECL_NODE"
);

/**
 * Массив соответствия номера узла его имени
 */
$nodeTypeDescs=Array(
    XML_ELEMENT_NODE	   =>  "Элемент",
    XML_ATTRIBUTE_NODE	   =>  "Атрибут",
    XML_TEXT_NODE	   =>  "текст",
    XML_CDATA_SECTION_NODE =>  "Секция CDATA",
    XML_ENTITY_REF_NODE    =>  "Ссылка на компонент",
    XML_ENTITY_NODE	   =>  "Компонент",
    XML_PI_NODE 	   =>  "Команды приложения",
    XML_COMMENT_NODE	   =>  "Комментарий",
    XML_DOCUMENT_NODE	   =>  "Документ",
    XML_DOCUMENT_TYPE_NODE =>  "Описание типа документа",
    XML_DOCUMENT_FRAG_NODE =>  "Фрагмент документа",
    XML_ENTITY_DECL_NODE   =>  "Описание компонента"
);

/**
 *
 */
function nodeTypeToString($type)
{
    global $nodeTypeNames;  //массив соответствия номера узла его типу
    global $nodeTypeDescs;  //массив соответствия номера узла его имени
    if (isset($nodeTypeNames[$type])) //есть такой тип узла
	$ret="$nodeTypeDescs[$type] ($nodeTypeNames[$type])";
    else
	$ret='Неизвестный тип узла '.$type;
    return $ret;
}
?>
