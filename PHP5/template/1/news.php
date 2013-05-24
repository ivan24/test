<?php ## Первый способ: смешение кода и шаблона.
echo "<html><body>\n";
echo "<h2>Последние новости:</h2>";
$f = fopen("../news.txt", "r");
for ($i=1; !feof($f) && $i<=5; $i++) {
  echo "<li>$i-я новость: ".fgets($f, 1024);
}
echo "</body></html>\n";
?>