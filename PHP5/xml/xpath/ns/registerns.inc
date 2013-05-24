<?php ## Функция registerns() привязки префиксов
/**
 *  Связать префиксы с областями имен.
 *
 *  @param domXpath $domxpath Xpath-запрос
 *
 *  @return  HTML-код описания префиксов
 */
function registerns($domxpath)
{
    global $_GET;
    $prefixes=$_GET['prefix'];  //массив префиксов
    $namespaces=$_GET['ns'];    //массив областей имен
    if (!is_array($prefixes)) return;
    $ret="<TABLE ALIGN=center><TR><TD CLASS='namespace'>\r\n";
    foreach($prefixes as $n => $prefix) {
	$namespace=$namespaces[$n];
	$ret.= "xmlns:$prefix=$namespace<BR>\r\n";
	$domxpath->register_namespace(utf8encode($prefix),
				      $namespace);
    }
    $ret.="</TD></TR></TABLE>\r\n";
    return $ret;
}
?>
