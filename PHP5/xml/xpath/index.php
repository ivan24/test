<?php ## PHPскрипт index.php определения Xpath-запроса?>
<HTML>
<HEAD>
<TITLE>Формирование Xpath-запроса к XML-файлу</TITLE>
</HEAD>
<BODY BCOLOR="#FFFFFF">
<FORM ACTION=showxpath.php
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
