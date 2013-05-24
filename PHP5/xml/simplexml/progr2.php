<?php ## Пример перекодировки имени свойства в UTF-8
      ##  во время выполнения скрипта?>
include 'unicode.inc';
$xml="<?xml version='1.0' encoding='".Encoding."'?>
<программа>
  <MTV>Канал MTV</MTV>
  <МузТВ>Канал МузТВ</МузТВ>
</программа>";

$prog=simplexml_load_string($xml);//загрузка XML-документа
$mtv=$prog->MTV;//элемент MTV 1-го уровня
echo utf8decode($mtv)."\r\n";

$mustv='$mustv=$prog->МузТВ;'; //элемент МузТВ 1-го уровня
eval (utf8encode($mustv));
echo utf8decode($mustv)."\r\n";
?>
