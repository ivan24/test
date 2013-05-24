<?php ## Выбор программы отображения свойств конкретного узла
require_once 'showdocumentprop.inc';
require_once 'showdtdprop.inc';
require_once 'showelementprop.inc';
require_once 'showpiprop.inc';
require_once 'showattrprop.inc';
require_once 'showcharacterdataprop.inc';
require_once 'showtextprop.inc';
require_once 'showentityprop.inc';

/**
 * Отобразить свойства конкретного узла
 *
 * @param domNode $domnode отображаемый узел
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function showSubclassProperties($domnode)
{?>
    ><TR
    ><TD
    >Свойства типа
    <B><?php echo nodeTypeToString($domnode->nodeType)?></B>:
    </TD
    ><TD
      ><TABLE<?php
    switch ($domnode->nodeType) {
	case XML_DOCUMENT_NODE:      //Документ
	    showDocumentProperties($domnode);break;
	case XML_ELEMENT_NODE:	    //Элемент
	    showElementProperties($domnode);break;
	case XML_COMMENT_NODE:	    //Комментарий
	    //Класс Comment подкласс CharacterData
	    showCharacterDataProperties($domnode);break;
	case XML_DOCUMENT_TYPE_NODE://Описатель типа документа
	    showDTDProperties($domnode);break;
	case XML_PI_NODE:	    //Команды приложения
	    showPIProperties($domnode);break;
	case XML_ATTRIBUTE_NODE:    //атрибут
	    showAttributeProperties($domnode);break;
	case XML_ENTITY_REF_NODE:   //Ссылка на компоненту
	    nullProperties($domnode);break;
	case XML_ENTITY_DECL_NODE:  //Описание компоненты
	    showEntityDeclProperties($domnode);break;
	case XML_TEXT_NODE: //Текстовый узел
	    //Класс Text подкласс CharacterData
	    showCharacterDataProperties($domnode);
	    showTextProperties($domnode);break;
	case XML_CDATA_SECTION_NODE://Секция CDATA
	    //Класс CDATASection подкласс Text
	    showCharacterDataProperties($domnode);
	    showTextProperties($domnode);break;
	}
    ?>
      ></TABLE
    ></TD
    ></TR<?php
}


/**
 * Заглушка для неотображаемых свойств
 *
 * @param domNode $domnode отображаемый узел
 *
 * @return void
 */
function nullProperties($domnode)
{ //дополнительные свойства отсутствуют
}
?>


