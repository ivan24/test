<?php ## Функция отображения свойств узла
require_once 'showsubclassprop.inc';
/**
 * Отобразить свойства узла в формате HTML
 *
 * @param domNode $domnode отображаемый узел
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function print_domNodeProperties($domnode)
{
    ?>
    <TABLE

    ><TR VALIGN=top
    ><TD ALIGN=right>nodeType(Тип_узла):</TD
    ><TD><?php echo nodeTypeToString($domnode->nodeType)?></TD
    ></TR

    <?php
	//отобразить свойства характерные для данного типа узла
	showSubclassProperties($domnode);
    ?>

    ><TR  VALIGN=top
    ><TD ALIGN=right>nodeName(Имя_узла):</TD
    <TD><?php echo utf8decode($domnode->nodeName)?></TD
    </TR

    ><TR  VALIGN=top
    ><TD ALIGN=right>nodeValue(Значение_узла):</TD
    ><TD><?php echo utf8decode($domnode->nodeValue)?></TD
    ></TR

    ><TR  VALIGN=top
    ><TD ALIGN=right>ownerDocument(Документ):</TD
    ><TD><?php showref('/',$domnode->ownerDocument)?></TD
    ></TR

    ><TR  VALIGN=top
    ><TD ALIGN=right>parentNode(Родительский узел):</TD
    ><TD><?php showref(ParentRef(),$domnode->parentNode)?></TD
    ></TR

    ><TR  VALIGN=top
    ><TD ALIGN=right>previousSibling(Предыдущий узел):</TD
    ><TD><?php showref(PreviousSiblingRef(),$domnode->previousSibling)?></TD
    ></TR

    ><TR  VALIGN=top
    ><TD ALIGN=right>nextSibling(Следующий узел):</TD
    ><TD><?php showref(NextSiblingRef(),$domnode->nextSibling)?></TD
    ></TR

    ><TR  VALIGN=top
    ><TD ALIGN=right>firstChild(Первый дочерний узел):</TD
    ><TD><?php showref(FirstChildRef(),$domnode->firstChild)?></TD
    ></TR

    ><TR  VALIGN=top
    ><TD ALIGN=right>lastChild(Последний дочерний узел):</TD
    ><TD><?php
	$nlast=($domnode->childNodes?$domnode->childNodes->length:0);
	showref(LastChildRef($nlast),$domnode->lastChild)?>
     </TD
    ></TR

    ><TR  VALIGN=top
    ><TD ALIGN=right>attibutes(Узлы атрибутов):</TD
    ><TD>
    <?php
    $attributes=$domnode->attributes;
    if ($attributes) {	  //есть атрибуты?
	//обойти список атрибутов
	for($i=0;$i<$attributes->length;$i++) {
	    $attributenode=$attributes->item($i);
	    $name=$attributenode->nodeName;
	    ?>
      <UL><?php echo "Узел аттрибута ". utf8decode($name)."";
	    //отобразить ссылку на атрибут
	    showref(AttrRef($i),$attributenode);
	  ?>
	</UL><?php
	}
    } else
	echo "отсутсвуют";
    ?>
    </TD
    ></TR

    ><TR  VALIGN=top
    ><TD ALIGN=right>childNodes(Дочерние узлы):</TD
    <TD>
    <?php
    if ($domnode->childNodes && $domnode->childNodes->length > 0) {
	for ($i=0;$i < $domnode->childNodes->length;$i++) {
	    $child=$domnode->childNodes->item($i);
	    ?>
      <LI><?php echo "childNodes[$i]";
	    showref(ChildRef($i),$child);//отобразить ссылку на узел
	  ?></LI>
	<?php
	}
    } else
	echo "отсутсвуют";
    ?>
    </TD
    ></TR
    ></TABLE>
    <?php
}
?>
