<?php ## PHPскрипт index.php определения Xpath-запроса
      ##  с поддержкой областей имен?>
<HTML>
<HEAD>
<TITLE>Формирование Xpath-запроса к XML-файлу</TITLE>
</HEAD>
<BODY BCOLOR="#FFFFFF">
<FORM ACTION=showxpath.php
<?php
if (isset($_GET['nsdecl'])) {
    $nsdecl=$_GET['nsdecl'];
    include 'ns.inc';
    foreach ($nsdecl as $setnamespace => $prefixesdecl){
	include $prefixesdecl;
	$namespacedecl[$setnamespace]=$ns;
    }
    //сформировать форму определения областей имен
    nsdeclform($namespacedecl);
}
?>
><TABLE

><TR
><TD ALIGN="right">Введите имя файла:</TD
><TD><INPUT NAME="xmlfile" SIZE="80"></TD
></TR

><TR
><TD ALIGN="right">Введите число отображаемых уровней:</TD
><TD><INPUT NAME="levels" SIZE="6"></TD
></TR

><TR
><TD ALIGN="right">Введите тропу XPath до начальной вершины</TD
><TD><INPUT NAME="contextpath" SIZE="80"></TD
></TR

><TR
><TD ALIGN="right">Введите запрос XPath</TD
><TD><INPUT NAME="xpath" SIZE="80"></TD
></TR

><TR
><TD COLSPAN="2" ALIGN="center"
><INPUT TYPE="submit" NAME=do VALUE="Выполнить"></TD
></TR


></TABLE
></FORM>
</BODY>
</HTML>
