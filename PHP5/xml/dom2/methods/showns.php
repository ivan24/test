<?php ## ѕрограмма showns.php отображени€ текущего списка
      ##  областей имен и префиксов
require_once 'unicode.inc';
$document=new domDocument('1.0',Encoding);
$document->load('multins.xml'); //«агрузить документ
$namespaces=Array();    //массив встреченных областей имен
$prefixes=Array();      //массив встреченных префиксов
showns($document->documentElement);//проанализировать
$document->formatOutput=true;
echo $document->saveXML();//вывести полученный документ

/**
 * ¬о всех первых текстовых узлах отобразить св€зь
 * встреченных префиксов и областей имен.
 * ‘ункци€ вызываетс€ рекурсивно.
 *
 * @param domNode $node начальный узел
 */
function showns($node)
{
    //массивы встреченных областей имен и префиксов
    global $namespaces,$prefixes;
    if ($node->nodeType==XML_ELEMENT_NODE){//узел €вл€етс€ элементом?
	$namespace=$node->namespaceURI;//определить его область имен
	if ($namespace) //если область имен непуста - запомнить ее
	    $namespaces[$namespace]=@$namespaces[$namespace]+1;
	$prefix=$node->prefix;//определить префикс элемента
	if ($prefix) //если префикс непуст - запомнить его
	    $prefixes[$prefix]=@$prefixes[$prefix]+1;
	if ($node->hasChildNodes()){//если есть дочерние элементы
	    //пройтись по ним
	    for ($child=$node->firstChild;$child;) {
		$nextchild=$child->nextSibling;
		showns($child);
		$child=$nextchild;
	    }
	}
    } elseif ($node->nodeType==XML_TEXT_NODE && //первый текстовый узел
	    $node===$node->parentNode->firstChild) {
	$Prefixes=$prefixes;//скопировать текущий массив префиксов
	$data="\r\n";
	foreach($namespaces as $namespace => $count) {
	    //пройтись по встреченным област€м имен
	    if ($node->isDefaultNamespace($namespace))
		{   //область имен по умолчанию
		$prefix='DEFAULT';  //назвать ее DEFAULT
	    } else //область имен не по умолчанию - запомнить ее префикс
		$prefix=$node->lookupPrefix($namespace);
	    if ($prefix) //если префикс есть?
		unset($Prefixes[$prefix]);//удалить его из Prefixes
	    else //область имен не св€зана с префиксом
		$prefix='UNKNOWN';  //область имен потер€на
	    //добавить в список описание области имен
	    $data.="\t\t$prefix == $namespace\r\n";
	}
	//в Prefixes остались префиксы, не св€занные со встреченными
	//област€ми имен
	foreach($Prefixes as $prefix => $count) {
	    //определить область имен, с которой св€зан префикс
	    $namespace=$node->lookupNamespaceURI($prefix);
	    if (!$namespace) //префикс потер€н?
		$namespace='UNKNOWN';
	    //добавить в список описание префикса
	    $data.="\t\t$prefix == $namespace\r\n";
	}
	//заместить текст узла сформированным списком
	// областей имен и префиксов
	$node->data=$data;
    } else {
	//остальные узлы (не элементы и не первые текстовые узлы) удалить
	$node->parentNode->removeChild($node);
    }
}
