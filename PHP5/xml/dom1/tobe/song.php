<?php ## Скрипт преобразования XML-файла схемы песни
require_once 'unicode.inc';
require_once 'formcouplets.inc';
require_once 'formRefrain.inc';
require_once 'formsong.inc';

$songdoc=new domDocument('1.0',Encoding);
$songdoc->substituteEntities=true;      //произвести подстановки
$songdoc->preserveWhiteSpace=false;     //игнорировать пробелы
$songdoc->load('song.xml');             //загрузить XML-файл

//удалить поддерево doctype за ненадобностью
$songdoc->removeChild($songdoc->doctype);

$song=$songdoc->documentElement;        //запомнить корневой элемент песня
//удалить из дерева узел заготовка, запомнив его в переменной $draft
//в документе осталась только схема куплетов
$draft=$song->removeChild($song->childNodes->item(0));
$Refrain=$draft->childNodes->item(0); //запомнить куплет
$refrain=$draft->childNodes->item(1); //запомнить реффрен
$couplets=$draft->childNodes->item(2);//запомнить заготовки куплетов

formRefrain($Refrain);  //доформировать куплет
formсouplets($couplets,$refrain); //доформировать заготовки куплетов
formsong($song,$couplets,$Refrain); //сформировать песню

$songdoc->formatOutput=TRUE;
$songdoc->save('SONG.xml');
?>
