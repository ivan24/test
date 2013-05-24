<?php ## Отображение параметров GZip-сжатия.
require_once "lib/config.php"; 
// Функция только устанавливает значение Cookie page_size_after.
function ob_saveCookieAfter($s) { 
  setcookie("page_size_after", strlen($s));
  return $s; 
}
// Аналогично, но для Cookie page_size_after.
function ob_saveCookieBefore($s) { 
  setcookie("page_size_before", strlen($s));
  return $s; 
}
// Устанавливаем конвейер обработчиков.
ob_start("ob_saveCookieAfter");
ob_start("ob_gzhandler", 9);
ob_start("ob_saveCookieBefore");
// Дальше можно выводить любой текст - он будет сжат.
?>
<!-- Выводим информацию о сжатии (в отдельном шаблоне). -->
<b><?include "gz.htm"?></b><hr>
<!-- Выводим текст страницы. -->
<pre>
<?=file_get_contents("../preg/largetextfile.txt")?>
</pre>