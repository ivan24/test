<?php ## Пример класса с методом.
class Math_Complex1 {
  public $re, $im;
  // Добавляет к текущему комплексному числу другое.
  function add(Math_Complex1 $y) {
    $this->re += $y->re;
    $this->im += $y->im;    
  }
  // Преобразует число в строку (например, для вывода).
  function __toString() {
    return "({$this->re}, {$this->im})";
  }
}
?>