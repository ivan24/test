<?php ## Получение адресов всех почтовых машин для указанного хоста.
// Подключаем библиотеку.
include_once "getmxrr.php";
// Проверяем работу функции.
$host = "thematrix.com";
getmxrr($host, $mxes, $weights)
  or die("Не удается получить DNS-запись для хоста $host."); 
echo "Ящики *@$host обслуживают следующие почтовые машины:<br>";
for ($i=0; $i<count($mxes); $i++) {
  echo "<li><tt>{$mxes[$i]}</tt>";
  echo " (вес = {$weights[$i]})\n";
}
?>
