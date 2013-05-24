<?php ## "Жадные" квантификаторы.
$str = "Hello, this <b>word</b> is <b>bold</b>!";
$re = '|<(\w+) [^>]* > (.*) </\1>|xs';
preg_match($re, $str, $pockets) or die("Нет тэгов.");
echo htmlspecialchars("'$pockets[2]' обрамлено тэгом '$pockets[1]'");
?>
