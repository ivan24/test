<?php ## ‘ункци€ showref() отображени€ ссылки на св€занный узел
/**
 * ќтобразить HTML-код ссылки на св€занный узел
 *
 * @param string $path тропа, указывающа€ на св€занный узел
 * @param domNode $domnode св€занный узел
 *
 * @return void  HTML-код помещаетс€ в буфер вывода
 */
function showref($path,$domnode) {
    global $xmlfile,$PHP_SELF;
    if ($domnode==null)    //узел отсутствет
	echo 'null';
    else
	echo ": <A HREF=\"$PHP_SELF?xmlfile=$xmlfile&path=$path\">".
	    domNodeTitle($domnode) .
	    "</A>";
}
?>
