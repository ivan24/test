<?php ## Сравнение скорости PCRE и POSIX.
$re = "a(((((.*)*)*)*)*)*b";
$st = "abcdefgh";
// Запускаем механизм PCRE (НКА).
$t = microtime(true);
$result = preg_match("/$re/", $st);
printf("PCRE($result): %.2f c<br>", microtime(true)-$t);
// Запускаем механизм POSIX (ДКА).
$t = microtime(true);
$result = ereg($re, $st);
printf("POSIX($result): %.2f c<br>", microtime(true)-$t);
?>