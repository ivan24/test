<?php ## Обратные ссылки.
$str = "Hello, this <b>word</b> is bold!";
$re = '|<(\w+) [^>]* > (.*?) </\1>|xs';
preg_match($re, $str, $pockets) or die("Нет тэгов.");
echo htmlspecialchars("'$pockets[2]' обрамлено тэгом '$pockets[1]'");
?>
