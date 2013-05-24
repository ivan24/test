<?php ## Неявный вызов метода.
require_once "lib/config.php"; 
require_once "Math/Complex2.php";
$addMethod = "add";
$a = new Math_Complex2(101, 303);
$b = new Math_Complex2(0, 6);
// Вызываем метод add() неявным способом.
call_user_func(array(&$a, $addMethod), $b);
echo $a;
?>