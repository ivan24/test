<?php ## Производный класс: фигура-круг.
require_once "ShapeA.php";
class Circle extends Shape {
  // Радиус круга в масштабе 1:1.
  private $radius;
  // Создает новый объект-круг с указанием радиуса.
  public function __construct($radius=100) {
    $this->radius = $radius;
    parent::__construct();
  }
  // Ображает круг на экране.
  public function show() {
    list ($x, $y) = $this->getCoord();
    $radius = $this->radius * $this->getScale();
    // Разместите "настоящий" код прорисовки круга ($x, $y, $radius).
    echo "Рисуем круг: ($x, $y, $radius)<br>";
  }
  // Стирает фигуру с экрана.
  public function hide() {
    list ($x, $y) = $this->getCoord();
    $radius = $this->radius * $this->getScale();
    // Разместите "настоящий" код стирания круга ($x, $y, $radius).
    echo "Стираем круг: ($x, $y, $radius)<br>";    
  }
}
?>