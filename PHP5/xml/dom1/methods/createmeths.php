<?php ## Пример использования методов класса domDocument
      ##  и конструкторов класса

require_once 'unicode.inc';
$listNodes=Array(
  "Element"		 => Array("string tagName"=>"имя тега"),
  "DocumentFragment"	 => Array(),
  "TextNode"		 => Array("string data"=>"текст"),
  "Comment"		 => Array("string data"=>"текст комментария"),
  "CDATASection"	 => Array("string data"=>"текст секции"),
  "ProcessingInstruction"=> Array("string target"=>"имя приложения",
				  "string data"=>"текст команд приложения"),
  "Attribute"		 => Array("string name"=>"имя атрибута"),
  "EntityReference"	 => Array("string name"=>"имя компонента")
);

$domdocument=new domDocument('1.0',Encoding);   //Документ

$tablenode=$domdocument->createElement('table');//Корневой элемент
$domdocument->appendChild($tablenode);  //добавить к документу

$comment=utf8encode('Заголовок таблицы');   //Комментарий
$tablenode->appendChild($domdocument->createComment($comment));

$trnode=$domdocument->createElement('tr');
$tablenode->appendChild($trnode);       //строка заголовка

$heads=Array('Метод класса domDocument','Конструктор new','Параметры');
foreach($heads as $head) {//сформировать теги TH заголовка
    $thnode=$domdocument->createElement('th');
    $trnode->appendChild($thnode);
    $textnode=$domdocument->createTextNode(utf8encode($head));
    $thnode->appendChild($textnode);
}

$comment=utf8encode('Тело таблицы');
$tablenode->appendChild($domdocument->createComment($comment));
foreach ($listNodes as $node => $pars){  //по всем типам узлов
    $comment=utf8encode("Узел $node");
    $tablenode->appendChild($domdocument->createComment($comment));

    //строка описания метода, класса, параметров
    $trnode=new domElement('tr');
    $tablenode->appendChild($trnode);

    $method="create$node()";
    //имя класса для методов createTextNode и
    // createAttribute формируется нестандартно
    $new=($node=='TextNode'?'domText()':
		($node=='Attribute'?'domAttr':"dom$node()"));

    foreach (Array($method,$new) as $funcname) {  //столбцы метода и класса
	$tdnode=new domElement('td');
	$trnode->appendChild($tdnode);
	$text=new domText(utf8encode($funcname));
	$tdnode->appendChild($text);    //добавить имя функции
    }

    $tdnode=new domElement('td');       //столбец описания параметров
    $trnode->appendChild($tdnode);
    $i=0;$n=count($pars);$content='';
    foreach($pars as $par => $descr) {	 //по всем параметрам
	//сформировать текстовые узлы: "параметр" " - " "описание"
	$tdnode->appendChild(new domText(utf8encode($par)));
	$tdnode->appendChild(new domText(" - "));
	$tdnode->appendChild(new domText(utf8encode($descr)));
	if (++$i < $n)  //если не последний параметр добавить тег BR
	    $tdnode->appendChild(new domElement('br'));
    }
}

$domdocument->formatOutput=true;
$tablexml=utf8decode($domdocument->saveXML($tablenode));
echo $tablexml; //вывести XHTML текст таблицы
?>
