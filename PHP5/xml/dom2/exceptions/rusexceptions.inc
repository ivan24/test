<?php ## Функция перевода кодов исключительный ситуаций в текст
/**
 * Перевести номер ошибки в описание на русском языке.
 *
 * @param int $code номер ошибки
 *
 * $return текст описания
*/
function domexeptionmessage($code)
{
    $rusmes=Array(
    DOM_INDEX_SIZE_ERR
	=> "Индекс отрицатален или больше допустимого значения",
    DOMSTRING_SIZE_ERR
	=> "Ошибка в размере строки типа DOMSTRING",
    DOM_HIERARCHY_REQUEST_ERR
	=> "Узел добавляется в место, к которому он не принадлежит",
    DOM_WRONG_DOCUMENT_ERR
	=> "Узел используется в документе, к которому он не принадлежит",
    DOM_INVALID_CHARACTER_ERR
	=> "В имени используется некоррекный символ",
    DOM_NO_DATA_ALLOWED_ERR
	=> "К узлу добавляются данные, которые он не может содержать",
    DOM_NO_MODIFICATION_ALLOWED_ERR
	=> "Попытка модификации узла, который не можеть быть изменен",
    DOM_NOT_FOUND_ERR
	=> "Доступ к узлу в данном контексте невозможен",
    DOM_NOT_SUPPORTED_ERR
	=> "Реализация не поддерживает данный объект или операцию ",
    DOM_INUSE_ATTRIBUTE_ERR
	=> "Плпытка добавить атрибут, который уже используется",
    DOM_INVALID_STATE_ERR   //DOM2
	=> "Попытка использовать недоступный объект",
    DOM_SYNTAX_ERR          //DOM2
	=> "Задана неверная строка",
    DOM_INVALID_MODIFICATION_ERR    //DOM2
	=> "Попытка изменения типа объекта",
    DOM_NAMESPACE_ERR       //DOM2
       => "Создать или изменить объект в данной области имен невозможно",
    DOM_INVALID_ACCESS_ERR  //DOM2
	=> "Оператор или операция не применимы к данному объекту",
    DOM_VALIDATION_ERR      //DOM3
	=> "Попытка добавления или удаления узла приводит к
     некорректному документу",
    );
    $message=@$rusmes[$code];
    if (!$message)
	$message("Неизвестный код ошибки $code");
    return $message."\r\n";
}
