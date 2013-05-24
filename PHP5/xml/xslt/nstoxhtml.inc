<?php ## Исходный текст функции nstoxhtml()
      ##  переноса документа в область имен xhtml
/**
 * Перенести xhtml документ в область имен xhtml.
 *
 * @param domDocument $outdom исходный xml-документ.
 *
 * @return domDocument	xhtml-документ в области имен xhtml
 */
function nstoxmhtl($outdom)
{
    $xhtmlNS='http://www.w3.org/1999/xhtml'; //Namespace для XHTML
    $publicId="-//W3C//DTD XHTML 1.0 Strict//EN";
    $systemId="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd";

    $domimpl=new domImplementation(); //создать объект
    //создать DocType для докумекнта
    $dtype=$domimpl->createDocumentType('html',$publicId,$systemId);
    //создать корневой элемент html
    $xhtmldom=$domimpl->createDocument($xhtmlNS,'html',$dtype);
    //скопировать кодировку из исходного документа
    $xhtmldom->encoding=$outdom->encoding;

    //удалить корневой элемент html
    $xhtmldom->removeChild($xhtmldom->documentElement);
    //импорировать корневой html элемент из исходного в созданный
    //тем самым поменяв область имен всех эго элементов
    $xhtmlhtml=$xhtmldom->importNode($outdom->documentElement,true);
    //добавить полученный элемент в качестве корневого
    $xhtmldom->appendChild(
	$xhtmldom->importNode($outdom->documentElement,true));
    return $xhtmldom;
}
?>
