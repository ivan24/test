<?php ## Внутренний редирект (только в CGI-версии PHP!)
// Вначале форсируем внутренний редирект.
Header("Status: 200 OK");
// Получаем URI-директорию текущего скрипта.
$dir = dirname($_SERVER['SCRIPT_NAME']);
// Осуществляем переадресацию по абсолютному (!) URI.  
Header("Location: $dir/result.php");
exit();
?>