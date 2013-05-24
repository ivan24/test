<?php ## Исходный текст функции loadHTMLbyURL()
      ## чтения HTML-файла с установкой корректной кодировки
      ##  в теге <meta http-equiv='Content-type' ...>
require_once 'unicode.inc';
/**
 * Загрузить HTML-файл по URL и установить кодировку. Функция
 * проверяет наличие тега
 * &lt;meta http-equiv=Content-type text/html; charset=Encoding&gt;
 * и в случае отсутсвия информации о кодировке формирует ее
 * согласно содержанию HTTP-заголовка Content-type.
 *
 *  @param string $url адрес HTML-файла
 */
function loadHTMLbyURL($url)   //загрузить HTML-файл по протоколу HTTP
{
    //разбить URL на составляющие: scheme, host, port, path
    extract(parse_url($url));
    if ($scheme!='http') {
	echo "В адресе страницы не указан протокол http";
	exit;
    }
    if (!isset($port))	//порт не указан
	$port='80'; //использовать порт 80
    if (!$fp=fsockopen($host,80,&$errno,&$errstr)) {
	//создать соединение с HTTP-сервером
	echo "Ошибка открытия адреса $url $errstr (ERRNO=$errno)\r\n";
	exit;
    }
    //запрос указанной страницы
    $req="GET $url HTTP/1.0
User-Agent: PHP/5
Host: $host:$port
Accept: */*

";
    //запросить информацию о странице
    fwrite($fp,$req);
    $contenthead="content-type:";
    $contentlen=strlen($contenthead);
    //прочитать заголовки ответа сервера и выделить строку кодировки
    while (!feof($fp)) {
	$str=fgets($fp,4096);
	$head=substr(strtolower($str),0,$contentlen);
	if (strcmp($contenthead,$head)==0)  //заголовок Content-Type?
	    $contenttype=trim(substr($str,$contentlen));    //запомнить его
	if (!trim($str)) break;     //конец заголовков ? -> выйти
    }
    if (!isset($contenttype))//кодировка не найдена ?
	$contenttype="text/html; charset=".Encoding;//взять стандартную
    //начать HTML-файл со строки meta с кодировкой
    $htmlcode="<meta http-equiv='Content-type' content='$contenttype'>";
    while (!feof($fp))	    //прочитать содержимое HTML-файла
	$htmlcode.=fgets($fp,4096);
    fclose($fp);
    return $htmlcode; //вернуть HTML-код с тегом meta вначале
}
?>
