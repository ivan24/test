<?php ## Формирование текста обнаруженной ошибки
require_once 'rusexceptions.inc';
$xml="<root><child/></root>";
try {
    $dom1=new domDocument();
    $dom1->loadXML($xml);
    $dom2=new domDocument();
    $dom2->loadXML($xml);
    $root1=$dom1->documentElement;
    $child1=$root1->firstChild;
    $root2=$dom2->documentElement;
    $root2->appendChild($child1);
} catch(domException $e) {
    $mes="\r\nОшибка в строке ". $e->getLine(). " скрипта " .
			     $e->getFile().":\r\n";
    $mes.=$e->__toString(). "\r\n";
    $mes.='Причина ошибки: '.domexeptionmessage($e->code);
    throw new Exception($mes);
}
