<?php ## Базовый класс - геометрическая фигура.
class Shape {
  // Любая фигура имеет координаты центра, а также масштаб.
  // Делая координаты скрытыми членами класса, мы гарантируем, 
  // что никто не сможет изменять их напрямую.
  private $x=0, $y=0, $scale=1.0;
  // Конструктор класса. Отображает фигуру на экране.
  public function __construct() {
    $this->show();
  }
  // Деструктор класса. Стирает фигуру с экрана.
  public function __destruct() {
    $this->hide();
  }
  // Переместить фигуру на ($dx, $dy) точек.
  public final function moveBy($dx, $dy) {
    // Вначале стираем фигуру с экрана.
    $this->hide();
    // Затем изменяем координаты.
    $this->x += $dx;
    $this->y += $dy;
    // Наконец, выводим фигуру на новом месте.
    $this->show();
  }
  // Изменить масштаб отображения фигуры.
  public final function resizeBy($coef) {
    $this->hide();
    $this->scale *= $coef;
    $this->show();
  }
  // Методы возвращают координаты центра и масштаб.
  public final function getCoord() { return array($this->x, $this->y); }
  public final function getScale() { return $this->scale; }
  //**
  //** "Защищенные" методы, доступные только для производных классов.
  //** Вызывать их в программе напрямую нельзя (да и не нужно).
  protected function hide() {
    die("Что здесь делать? Неизвестно!");
  }
  protected function show() {
    die("Что здесь делать? Неизвестно!");  
  }
}
?>