<?php ## Перехват управления в случае возникновения ошибки
$dom=new domDocument();
$root=new domElement('root');
try {   //добавить аргументы к элементу
    appendattrs($root,Array('id'=>1,'name'=>'first'));
} catch(domException $exception) {
    //если возникла исключительная ситуация
    print_r($exception);//отобразить состояние ошибки
    if ($exception->code==DOM_NO_MODIFICATION_ALLOWED_ERR) {
	//если элемент не имеет владельца
	$dom->appendChild($root);//добавить его к документу
	//и установить значения по умолчанию
	appendattrs($root,Array('id'=>0,'name'=>'default'));
    } else //другие ошибки обработать стандартно
	throw($exception);
}
echo $dom->saveXML();

/**
 * Добавить указанные атрибуты к элементу.
 *
 * @param domElement $element корректируемый элемент
 * @param array $attr ассоциативный массив значений атрибутов
 */
function appendattrs($element,$attrs)
{
    foreach($attrs as $name => $value) {//для всех элементов массива
	//установить указанный атрибут
	$element->setAttribute($name,$value);
    }
}
?>
