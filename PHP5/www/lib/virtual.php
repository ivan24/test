<?php ## Эмуляция функции virtual().
if (!function_exists("virtual")) {
  // Условно определяемая функция
  function virtual($url) { 
    $script_name = $_SERVER['SCRIPT_NAME'];  
    $server = $_SERVER['HTTP_HOST']; // хост:порт
    // Преобразуем относительный URI в абсолютный.
    if ($url[0] != '/') {
      // Адрес относительно ДИРЕКТОРИИ скрипта.
      $dir = str_replace("\\", "/", dirname($script_name));
      $url = substr($dir, -1)=="/"? $dir.$url : "$dir/$url";
    }
    // Открываем соединение.
    $f = @fopen("http://$server$url", "rb");
    if (!$f) { 
      echo "[an error ocurred while processing this directive: $url]";
      return false;
    }
    // Теперь просто читаем все и выводим с помощью echo.
    while (!feof($f)) echo fread($f, 10000);
    fclose($f);
    return true;
  }
}
# Пример использования:
# echo "<hr><hr>";
# virtual("..");
# echo "<hr><hr>";
?>
