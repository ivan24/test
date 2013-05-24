<?php ## Функция для запрета кэширования страницы браузером.
function nocache() {
  Header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
  Header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  Header("Cache-Control: no-cache, must-revalidate");
  Header("Cache-Control: post-check=0,pre-check=0");
  Header("Cache-Control: max-age=0");
  Header("Pragma: no-cache");
}
?>