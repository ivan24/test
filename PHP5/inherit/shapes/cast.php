<?php ## Уточнение и совместимость типов.
require_once "Circle.php";
function moveSize(Shape $obj) {
  $obj->moveBy(10, 0);
  $obj->resizeBy(10);
}
$shape = new Circle();
moveSize($shape);
?>