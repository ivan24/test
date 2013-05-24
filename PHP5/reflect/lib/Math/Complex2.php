<?php ## Пример класса с конструктором.
class Math_Complex2 {
  public $re, $im;
  // Инициализация нового объекта.
  function __construct($re, $im) {
    $this->re = $re;
    $this->im = $im;
  }
  // Добавляет к текущему комплексному числу другое.
  function add(Math_Complex2 $y) {
    $this->re += $y->re;
    $this->im += $y->im;    
  }
  // Преобразует число в строку (например, для вывода).
  function __toString() {
    return "({$this->re}, {$this->im})";
  }
}
?>