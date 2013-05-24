<?php ## Исходный текст функции nsdeclform()
function nsdeclform($namespacedecl)
{
    $n=0;
    foreach ($namespacedecl as $namens => $prefixarray) {
    ?>
    ><TABLE ALIGN=center BORDER=1
    ><TR
    ><TH COLSPAN=2>Определите префиксы областей имен:
      "<?php echo $namens?>"</TH
    ></TR
    ><TR
    ><TH>Префикс</TD
    ><TH>Область имен</TD
    ></TR
    <?php
	foreach ($prefixarray as $prefix=>$namespace) {?>
	><TR
	><TD>xmlns:<INPUT NAME="prefix[<?php echo $n?>]"
			VALUE="<?php echo $prefix?>"/></TD
	><TD><INPUT TYPE="hidden" NAME="ns[<?php echo $n?>]"
			VALUE="<?php echo $namespace?>"/>
	    <?php echo $namespace?></TD
	></TR
	<?php
	$n++;
	}?>
    ></TABLE
    <?php
    }
}
?>
