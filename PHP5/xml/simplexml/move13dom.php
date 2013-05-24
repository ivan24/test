<?php ## Пример скрипта move13dom.php использующего расширение dom
$dom=new domDocument;
$dom->load('game.xml'); //загрузить документ
$game=$dom->documentElement;    //корневой элемент
$move=$game->getAttribute('moves')+1; //атрибут moves корневого элемента
$game->setAttribute('moves',$move); //установить новое значение
foreach($game->childNodes as $l){//для всех дочерних элементов
    if ($l->nodeName=='l1') {	 //искомый элемент l1?
	foreach ($l->childNodes as $c){  //для всех дочерних элементов
	    if ($c->nodeName=='c3') { //искомый элемент c3?
		 //установить атрибут move и значение элемента
		$c->setAttribute('move',$move);
		$c->firstChild->data='O';
	    }
	}
    }
}
echo $dom->saveXML();
?>
