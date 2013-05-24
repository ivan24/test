<?php ## Корректность PHP_OutputBuffering::__toString().
require_once "lib/config.php"; 
require_once "PHP/OutputBuffering.php";
// Перехватываем выходной поток в программе.
$h1 = new PHP_OutputBuffering();
  // Выводим некоторый текст.
  echo "Текст в первом буфере.";
  // Еще раз перехватываем выходной поток (вложенным образом).
  $h2 = new PHP_OutputBuffering();
    // Выводим другой текст текст.  
    echo "Текст во втором буфере.";
    // Теперь сохраняем в переменных, что было накоплено в буферах.
    $first  = $h1->__toString();
    $second = $h2->__toString();  
  // Уничтожаем второй буфер.  
  $h2 = null;
// Уничтожаем первый буфер.  
$h1 = null;
// Выводим сохраненный ранее текст.
echo "1: $first<br>";
echo "2: $second<br>";
?>