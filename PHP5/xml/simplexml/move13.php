<?php ## Пример скрипта move13.php использующего расширение simplexml
$game=simplexml_load_file('game.xml');
$move=$game['moves']+1;
$game['moves']=$move;
$game->l1->c3['move']=$move;
$game->l1->c3='O';
echo $game->to_xml_string();
?>
