<?php ## Посылка почты вручную, минуя SMTP-сервер провайдера.
// Подключаем эмуляцию функции getmxrr().
include_once "../net/getmxrr.php";
// Подключаем остальные функции.
include_once "lib/template.php";
include_once "lib/mailenc.php";
include_once "lib/mailx.php";
include_once "lib/socketmail.php";

$mail = template("mail.php.eml", array(
  "to"   => "Кто-то очень страшный <somebody@thematrix.com>", 
  "text" => "Проверка слуха!"
));
$mail = mailenc($mail);
mailx_manual($mail, $reason)
  or die("Errors:<br>".join("<br>", $reason));
echo "Почта отослана.";
?>