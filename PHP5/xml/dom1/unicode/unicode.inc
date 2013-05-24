<?php ## Функции перевода строк из кодировки WINDOWS-1251 в UTF-8 и обратно
setlocale(LC_ALL,"ru_RU.CP1251");

//Стандартная кодировка документа
define('Encoding','WINDOWS-1251');

//Заголовок XML-документа
define ('XMLHead',"<?xml version='1.0' encoding='".Encoding."'?>");

/**
 * Перекодировать строку в кодировку UTF-8
 *
 *  @param string str    перекодируемая строка
 *  @param string encode исходная кодировка (по умолчанию WINDOWS-1251)
 *
 * @return  перекодированная строка в кодировке UTF-8
 */
function utf8encode($str,$encode=Encoding)
{
    return iconv($encode,'UTF-8',$str);
}

/**
 * Перекодировать строку из кодировки UTF-8
 *
 *  @param string str    перекодируемая строка в кодировке UTF-8
 *  @param string encode целевая кодировка (по умолчанию WINDOWS-1251)
 *
 * @return  перекодированная строка в указанной кодировке
 */
function utf8decode($str,$encode=Encoding)
{
    return iconv('UTF-8',$encode,$str);
}
?>
