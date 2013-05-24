<?xml version="1.0" encoding="WINDOWS-1251"?>
<?php ## PHP-программа, формирующая XML-описание программы передач?>
<программа день="01.09.2001">
<!--в тело тега программа входит PHP-скрипт -->
<?php
require_once 'daysprogramm.class';
$ListProgram=new DaysProgram("01.09.2001");
while ($channel=$ListProgram->next_channel()) {
    echo "  <канал название=\"$channel\">\r\n";
    while (list($program,$time)=$ListProgram->next_program()) {
	if ($program)
	    echo "    <передача начало=\"$time\">$program</передача>\r\n";
	else
	    echo "    <технический_перерыв начало=\"$time\" />\r\n";
    }
    echo " </канал>\r\n";
}
?>
</программа>
