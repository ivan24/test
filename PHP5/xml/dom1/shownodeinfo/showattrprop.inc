<?php ## Отображение свойств класса domAttr
/**
 * Отобразить свойства узла класса domAttr в формате HTML
 *
 * @param domAttr $domattr узел атрибута XML-документа
 *
 * @return void  HTML-код помещается в буфер вывода
 */
function showAttributeProperties($domattr)
{?>

    ><TR
    ><TD>name (Имя):</TD
    ><TD><?php echo utf8decode($domattr->name)?></TD
    ></TR

    ><TR
    ><TD>value (Значение):</TD
    ><TD><?php echo utf8decode($domattr->value)?></TD
    ></TR

    ><TR
    ><TD>specified(Задан в документе):</TD
    ><TD><?php echo ($domattr->specified?'Да':'Нет')?></TD
    ></TR

    ><TR
    ><TD>ownerElement (Принадлежит):</TD
    ><TD><?php echo showref(ownerElementRef(),$domattr->ownerElement)?></TD
    ></TR

    ><TR
    ><TD>schemaTypeInfo (Тип схемы):</TD
    ><TD><?php //echo $domattr->schemaTypeInfo?></TD
    ></TR

<?php
}

/**
 * Сформировать путь, указывающий на элемент, к которому
 * принадлежит атрибут.
 *
 * @return string путь до элемента
 */
function ownerElementRef()
{
    global $path;
    $nodepath=$path;
    $n=strrpos($path,'@');  //позиция последнего символа @
    if ($n >= 0)
	$nodepath=substr($path,0,$n-1); //путь до владельца
    return ($nodepath);
}
?>
