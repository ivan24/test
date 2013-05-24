<?php ## Исходный текст программ setImportsLevel() и setOutputFormat()
/**
 * Добавить в XSL-программу $domxsl операторы import согласно уровню.
 *
 * @param domDocument $domxsl XSLT-документ
 * @param int $importlevel число уровней импортирования
 *
 * @return  модифицированный XSLT-документ с добавленными
 *	    операторами <xsl:import .../>
 */
function setImportsLevel($domxsl,$importlevel)
{
    define ('XSLTNS','http://www.w3.org/1999/XSL/Transform');
    $importfiles=Array( //список импортируемых файлов по уровням
	0=>Array('stubs.xsl'),
	1=>Array('song.xsl'),
	2=>Array('couplet.xsl','refrain.xsl','final.xsl'),
	3=>Array('line.xsl')
    );

    //корневой элемент
    $stylesheet=$domxsl->documentElement;
    //элемент перед которым вставлять элементы <xsl:import href=''/>
    $beforeNode=$stylesheet->firstChild;
    //просмотреть файлы уровней
    foreach ($importfiles as $level => $xslfiles) {
	//если просматриваемый уровень больше требуемого - выйти
	if ($level > $importlevel) break;
	foreach ($xslfiles as $xslfile) {
	    //просмотреть список xsl-файлов, подключаемыз в уровне
	    //создать элемент <xsl:import href='имя_xsl-файла'/>
	    $importnode=$domxsl->createElementNS(XSLTNS,'xsl:import');
	    $importnode->setAttribute('href',$xslfile);
	    //вставить элемент перед 'бывшим' первым элементом
	    $stylesheet->insertBefore($importnode,$beforeNode);
	}
    }
}

/**
 * Установить атрибут method элемента output XSLT-программы $domxsl.
 *
 * @param domDocument $domxsl XSLT-документ
 * @param string $importlevel $outputformat новое значение атрибута method
 *
 * @return  модифицированный XSLT-документ
 */
function setOutputFormat($domxsl,$outputformat)
{
    $xpath=new domxpath($domxsl);
    //тропа до первого элемента output с атрибутом method
    $xpathStr='/xsl:stylesheet/xsl:output/@method';
    $nodeList=$xpath->query($xpathStr); //найти список узлов по тропе
    $methodNode=$nodeList->item(0); //взять первый узел
    if ($methodNode)//узел есть?
	$methodNode->value=$outputformat;
	//установить требуемый режим вывода
}
?>
