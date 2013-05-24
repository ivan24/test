<?php ## Абстрактный класс - геометрическая фигура.
abstract class Shape {
  private $x=0, $y=0, $scale=1.0;
  public function __construct() {
    $this->show();
  }
  public function __destruct() {
    $this->hide();
  }
  public final function moveBy($dx, $dy) {
    $this->hide();
    $this->x += $dx;
    $this->y += $dy;
    $this->show();
  }
  public final function resizeBy($coef) {
    $this->hide();
    $this->scale *= $coef;
    $this->show();
  }
  public final function getCoord() { return array($this->x, $this->y); }
  public final function getScale() { return $this->scale; }
  // Абстрактные методы.
  abstract protected function hide();
  abstract protected function show();
}
?>