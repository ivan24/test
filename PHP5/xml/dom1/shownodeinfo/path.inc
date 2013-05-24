<?php ## Функция выборки узла по тропе (файл path.inc)
/**
 * Выбирает узел по указанной тропе.
 *
 * @param domDocument $dom  корневой узел
 * @param string $path	    тропа до искомого элемента
 *
 * @return узел класса domNode
 */
function getNodeByPath($dom,$path)
{
    $node=$dom;
    if (substr($path,0,1)=='/')
	$path=substr($path,1);
    if (strlen($path)==0) return $dom;	    //корневой элемент
    $Path=split('/',$path); //разбить путь на составляющие
    foreach($Path as $numchild) {   //по всем уровням пути
       if (substr($numchild,0,1)=='@') {      //аттрибут
	    $numchild=substr($numchild,1); //удалить @ из номера
	    $list=$node->attributes;//взять список атрибутов
       } else //дочерний узел
	    $list=$node->childNodes;//взять список дочерних узлов
       $node=$list->item((int)$numchild-1);//выделить указанный узел
    }
    return $node;
}
?>
