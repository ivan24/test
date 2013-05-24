<?php ## Создание объекта неизвестного класса.
require_once "lib/config.php"; 
require_once "Math/Complex2.php";
// Пусть имя класса хранится в переменной $className.
$className = "Math_Complex2";
// Создаем новый объект.
$obj = new $className(6, 1);
echo "Созданный объект: $obj";
?>