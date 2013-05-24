<?php ## Функция textopenclose($node) формирования XML-текста
      ##  текстовых узлов
/**
 *  Сформировать открыавабщие и закрывающие XML-код
 *  для текстовый узлов.
 *
 *  @param domNode $node отображаемый элемент
 *
 *  @return array массив отрывающих и закрывающих кодов
 */
function textopenclose($node)
{
    switch($node->nodeType) { //тип узла
	case XML_COMMENT_NODE:	    //Comment
	    $open='<!--';
	    $close='-->';
	    break;
	case XML_CDATA_SECTION_NODE:	    //CDATASection
	    $open='<![CDATA [';
	    $close=']]>';
	    break;
	case XML_TEXT_NODE: //Text
	    $open='';
	    $close='';
	}
    return Array($open,$close);
}
?>
