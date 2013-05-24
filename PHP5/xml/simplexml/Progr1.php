<?php ## Пример указания имени свойства в кодировке UTF-8
include 'unicode.inc';
$xml="<?xml version='1.0' encoding='UTF-8'?>
<программа>
  <MTV>Канал MTV</MTV>
  <МузТВ>Канал МузТВ</МузТВ>
</программа>";

$prog=simplexml_load_string($xml);//загрузка XML-документа
$mtv=$prog->MTV;//элемент MTV 1-го уровня
echo utf8decode($mtv)."\r\n";

$mustv=$prog->МузТВ;    //элемент МузТВ 1-го уровня
echo utf8decode($mustv)."\r\n";
?>
