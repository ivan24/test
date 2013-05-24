<?php ## Перегрузка оператора преобразования в строку.
require_once "lib/config.php"; 
require_once "Math/Complex1.php";
$a = new Math_Complex1;
$a->re = 314;
$a->im = 101;
echo "Значение: $a";
?>
