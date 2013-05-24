<?php ## Исходный текст PHP-функций Line(), processTime(), addSummaryInfo()
/**
 * Оформить выводимую строку песни.
 *
 * Функция вызывается из xslt-template и возвращает
 * обрабатываемый элемент, заключенный в элемент
 * div с выделенным первым словом:
 * <div class='line'><b>Первое_слово</b>осталная_часть_строки</div>
 *
 * @param array $nodes массив из одного узла строки класса domNode
 *
 * @return int $beginLineTime время начала обработки строки
 * @return domElement  сформированный элемент строки
 */
function Line($nodes)
{
    global $beginLineTime;  //время начала обработки строки
    $beginLineTime=explode(' ',microtime());

    $node=$nodes[0];	    //обрабатываемый узел
    $line=trim($node->nodeValue);   //убрать лишние пробелы
    $n=strpos($line,' ');   //позиция первого пробела
    $begin=substr($line,0,$n); //часть строки до пробела
    $end=substr($line,$n); //часть строки посде пробела

    $linedom= new domDocument(); //создать новый документ
    $div=$linedom->createElement('div'); //корневой элемент div
    $div->setAttribute('class','line');  // <div class='line'/>

    $b=$linedom->createElement('b'); //часть до пробела - bold
    $b->appendChild($linedom->createtextNode($begin));
    $div->appendChild($b);
    //добавить часть после строки пробела
    $div->appendChild($linedom->createtextNode($end));

    $linedom->appendChild($div); //добавить элемент div
    return $linedom->documentElement;
}

/**
 * Подсчитать время обработки строки и число строк.
 *
 * @return $nLines число обработанных строк
 * @return $summsecs суммарное время обработки строк
 * @return int время обработки текущей строки
 */
function processTime()
{
    global $nLines,$beginLineTime,$summsecs;
    $nLines++;	    //увеличить число прочитанных строк
    $endLineTime=explode(' ',microtime());  //текущее время
    //время обработки
    $msecs=($endLineTime[0] + $endLineTime[1]) -
	   ($beginLineTime[0] + $beginLineTime[1]);
    $summsecs+=$msecs;	//подсчитать суммарное время обработки строк
    return $msecs;  //время обработки строки
}


include "unicode.inc";
/**
 * Добавить итоговую информацию в начало XHTML-документа.
 *
 * @param domDocument $outdom XHTML-документ
 */
function addSummaryInfo($outdom)
{
    global $nLines, //число обработанных строк и Рефренов
	   $summsecs;  //суммарное время обработки строк и Рефренов
    $xpath=new domxpath($outdom);
    $body=$xpath->query('//body');
    $body=$body->item(0); //найти по тропе //body элемент body

    $text= utf8encode("Всего строк: $nLines.
	    Суммарное время обработки: $summsecs;");
    //поместить $text в элемент div
    $div=$outdom->createElement('div'); //корневой элемент div
    $div->setAttribute('class','summary');  // <div class='summary'/>
    $div->appendChild($outdom->createTextNode($text));
    //вставить div первым в дочерние элементы <body><div>...</div>...
    $body->insertBefore($div,$body->firstChild);
}
?>
