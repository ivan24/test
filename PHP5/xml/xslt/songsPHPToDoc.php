<?php ## Исходный текст скрипта songsPHPToDoс.php
require_once ('xslmodify+.inc');
$importlevel=3; 	//Уровень загружаемых XSLT-программ
$nsong=0; //сдвиг номеров песен
$outputformat='xml';
$xslfile='songs.xsl';   //XSLT-файл
$xmlfile='songs.xml';   //XML-файл

if ($argc>1) $importlevel=$argv[1];
if ($argc>2) $nsong=$argv[2];
if ($argc>3) $outputformat=$argv[3];
if ($argc>4) $xslfile=$argv[4];
if ($argc>5) $xmlfile=$argv[5];

$domxml=new domDocument();
$domxml->substituteEntities=true;      //произвести подстановки
$domxml->load($xmlfile); //загрузить XML-файл

$domxsl=new domDocument();
$domxsl->load($xslfile);//загрузить XSL-файл

//загрузить xsl-файлы требуемого уровня
setImportsLevel($domxsl,$importlevel);
//установить формат вывыода
setOutputFormat($domxsl,$outputformat);

$xsl=new xsltProcessor();//создать XSLT-процессор
@$xsl->importStylesheet($domxsl); //оттранслировать XSLT-документ

//передать XSLT-программе параметр nsong - сдвиг номеров песен
$xsl->setParameter('','nsong',$nsong);

require_once ('xsltphpfuncs.inc');  //подкючить PHP-функции
$xsl->registerPHPFunctions();   //зарегисторовать их
$outdom=$xsl->transformtoDOC($domxml); //выполнить трансформацию
addSummaryInfo($outdom);    //добавить итоговую информацию

include "nstoxhtml.inc";
$outdom=nstoxmhtl($outdom);     //перенос в простанство xhtml
$outdom->formatOutput=true;
echo $outdom->saveXML();        //вывод документа
?>
