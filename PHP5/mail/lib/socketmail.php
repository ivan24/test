<?php
// Функция для посылки почты вручную, минуя SMTP-сервер провайдера.
// Использует getmxrr(), которая в Windows не поддерживается. 
function mailx_manual($mail, &$reason=false) {
  $reason = array();
  // Выделяем заголовок To.
  $to = "";
  if (preg_match('/^To:\s*([^\r\n]*)[\r\n]*/m', $mail, $p)) {
    $to = @$p[1]; // сохраняем
  }
  // Вначале выделяем имя хоста.
  if (!preg_match('/@([\w.-]*)/', $to, $pockets)) {
    $reason[] = "invalid e-mail address - $to: no host";
    return false;
  }
  $host = $pockets[1];
  // По стандарту SMTP, если нет ни одной MX-записи, то в качестве
  // почтового сервера выступает сам хост.
  if (!getmxrr($host, $mxes, &$weights)) {
    $mxes = array($host);
  }
  // Проходимся по всем MX-записям. Для простоты веса не 
  // учитываем - большой беды от этого не будет.
  foreach ($mxes as $mx) {
    $result = socketmail($mx, $mail, $r);
    $reason = array_merge($reason, $r);        
    // Если письмо отослано, все сделано.
    if ($result) return true;
  }
  $reason[] = "could not connect to any of (".join(", ", $mxes).")";
  return false;
}

// Функция открывает соединение с SMTP-сервером $host
// и пытается отправить через него письма, заданные в $mails.
// Все ошибки накапливаются в необязательной переменной $reason
// в виде списка строк. В случае, если отправка всех писем
// прошла успешно, функция возвращает true, иначе - false.
// Каждое письмо в $mails должно быть представлено в формате:
// "Заголовки\r\n\r\nТело". Функция не заботится о правильном
// кодировании заголовков, предполагая, что это уже было 
// сделано ранее.
function socketmail($host, $mails, &$reason=false) { 
  // Открываем соединение с почтовым сервером.
  $reason = array();
  $f = @fsockopen($host, 25, $errno, $errstr, 30);
  if (!$f) {
    $reason[] = "could not open $host:25"; 
    return false;
  }
  $answer = fgets($f, 1024); 

  // Сигнализируем о начале обмена данными.
  fputs($f, "HELO {$_SERVER['SERVER_NAME']}\r\n"); 
  $answer = fgets($f, 1024); 

  // Отправляем все письма для этого сервера в цикле.
  // Все это происходит за одно соединение с сервером.
  if (!is_array($mails)) $mails = array($mails);
  foreach ($mails as $i=>$data) { 
    // Получаем заголовки и тело сообщения.
    list ($headers, $body) = preg_split('/\r?\n\r?\n/', $data, 2);
    // Получаем заголовок From.
    if (!preg_match('/^From:\s*(.*)/mi', $headers, $pockets)) {
      $reason[] = "could not find required From: header in mail #$i";
      continue;
    }
    $from = getEmail($pockets[1]);    
    if (!$from) {
      $reason[] = "no email in From: header in mail #$i";
      continue;
    }
    // Получаем заголовок To.
    if (!preg_match('/^To:\s*(.*)/mi', $headers, $pockets)) {
      $reason[] = "could not find required To: header in mail #$i";
      continue;
    }
    $to = getEmail($pockets[1]);
    if (!$to) {
      $reason[] = "no email in To: header in mail #$i";
      continue;
    }
    // Т.к. точка в протоколе SMTP свидетельствует о конце данных,
    // (см. ниже), мы ее удваиваем.
    $data = preg_replace("/\n\./", "\n..", $data);
    // Отправляем управляющие команды SMTP.
    do {
      if (!smtp_say($f, "MAIL FROM: <$from>", $reason)) break; 
      if (!smtp_say($f, "RCPT TO: <$to>", $reason)) break; 
      if (!smtp_say($f, "DATA", $reason)) break;  
      // Печатаем данные.
      fputs($f, trim($data)."\r\n");
      if (!smtp_say($f, ".", $reason)) break;  
    } while (false);
    // Конец письма.
    !smtp_say($f, "RSET", $reason);
  } 

  // Говорим серверу об окончании работы.
  @smtp_say($f, "QUIT", $reason);
  fclose($f); 
  return !count($reason);
}

function smtp_say($f, $cmd, &$reason) {
  fputs($f, "$cmd\r\n"); 
  $answer = fgets($f, 1024); 
#  echo "&gt; $cmd<br>&lt; $answer<br>";
  if (!preg_match('/^(250|354|221)/', $answer)) { $reason[] = "$answer"; return; }
  return true;
}

// Извлекает первый адрес E-mail из заголовка To или From.
// Внимание: упрощенная версия!
function getEmail($header) {
  if (!preg_match('/([\w.-]+@[\w.-]+)/s', $header, $p)) return;
  return $p[1];
}

?>