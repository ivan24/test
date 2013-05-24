<?php ## Поиск слов с тегами <ударение> в указанном куплете
include 'unicode.inc';
$dom=new domDocument('1.0',Encoding);
$dom->load('SONG.xml');
$stress=$dom->getElementsByTagname(utf8encode('ударение'));
for ($i=0;$i<$stress->length;$i++) {
    $node=$stress->item($i);
    echo utf8decode($dom->saveXML($node))."\n";
}
?>
