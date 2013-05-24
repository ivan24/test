<?php ## Вывод таблицы поддерживаемых модулей DOM
$head='Поддержка модулей DOM в '. phpversion();?>
<HTML>
<HEAD><TITLE><?php echo $head?></TITLE>
<BODY>
<CENTER><H4><?php echo $head?></H4></CENTER>
<?php
require_once 'unicode.inc';
require_once 'countdepth.inc';
$dom=new domDocument();
$dom->preserveWhiteSpace=false;
$dom->load('modules.xml');//загрузить XML-файл иерархии DOM-модулей

$depth=countDepth($dom->documentElement,0);//определить глубину

require_once 'featurestable.class';
$table=new featuresTable(); //вывести TABLE
$table->leftHead($depth); //вывести заголовок таблицы
$table->rightHead($depth);
include 'formrow.inc';
formRow($dom->documentElement,0); //вывести строки таблицы
unset($table);
?>
</BODY></HTML>
