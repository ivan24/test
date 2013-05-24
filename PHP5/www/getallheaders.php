<?php ## Получение заголовков запроса.
# Работает только если PHP установлен в виде модуля Apache!
$headers = getallheaders();
Header("Content-type: text/plain");
print_r($headers);
?>
