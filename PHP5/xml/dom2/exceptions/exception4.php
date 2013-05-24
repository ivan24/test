<?php ## Пример замены функции обработки ошибок
$xml="<root><child11/><child2/></root1>";
$dom=new domDocument();
$old_error_handler=set_error_handler('domerrorhandler');
$ret=$dom->loadXML($xml);
echo $dom->saveXML();

/**
 * Замещающая функция обработки ошибок
 *
 * @param int $errno номер ошибки
 * @param string $errstr описание ошибки
 * @param string $errfile файл, где встречена ошибка
 * @param int $номер ошибочной строки
 */
function domerrorhandler($errno, $errstr, $errfile, $errline)
{
    $mes="\r\nОшибка загрузки документа.
    Файл: $errfile.
    Строка: $errline.
    Код:$errno
    Ошибка:\r\n $errstr";
    throw new Exception($mes);
}

