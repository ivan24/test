<?php ## �������� ����������� �������.
require_once "Circle.php";
// ������� ������� ����.
$shape = new Circle();
// ����� �� ����� "������", ��� $shape - ��� � ����������������
// ����, �������� � ���, ��� � ����� �������������� �������.
sleep(1); echo "������ ��������� �����...<br>";
$shape->moveBy(101, 6);
sleep(1); echo "������ ��������� �����...<br>";
$shape->resizeBy(2.0);
sleep(1); echo "������ ��������� �����...<br>";
?>