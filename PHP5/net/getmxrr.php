<?php ## Эмуляция функции getmxrr() для Windows.
if (!function_exists("getmxrr")) {
  function getmxrr($hostname, &$hosts, &$weights=false) {
    $hosts = $weights = array();
    // Не идеальный способ, но работающий: используется внешняя
    // программа nslookup, доступная в WIndows NT/2000/XP/2003.
    exec("nslookup -type=mx $hostname", $result);
    // Построчно перебираем ответ утилиты.
    foreach ($result as $line) {
      // Выделяем имя почтового сервера.
      if (preg_match('/mail\s+exchanger\s*=\s*(\S+)/', $line, $pock)) {
        $hosts[] = $pock[1];
        // Также выделяем вес.
        if (preg_match("/MX\s+preference\s*=\s*(\d+)/", $line, $pock))
          $weights[] = $pock[1];
        else
          $weights[] = 0;
      }
    }
    return count($hosts) > 0;
  }
}
// В PHP5 появился синоним для getmxrr() - его мы тоже эмулируем.
if (!function_exists("dns_get_mx")) {
  function dns_get_mx($hostname, &$hosts, &$weights) {
    return getmxrr($hostname, $hosts, $weights);
  }
}
?>