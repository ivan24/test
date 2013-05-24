<?php ## Множественное наследование интерфейсов.
// Сущность: "материальный объект".
interface IWorldObject {
  public function getCoord();  // возвращает координаты объекта
  // Обратите внимание, тело метода не указывается!
}
// Сущность: "устройство с колесами".
interface IWheeled {
  public function getNumWheels(); // возвращает число колес
}
// Сущность: "транспортное средство". ВНИМАНИЕ: при расширении 
// интерфейсов нужно использовать ключевое слово extends, а не 
// implements! Конечно, допустимо множественное расширение.
interface ITransport extends IWorldObject {
  public function getNumPassengers(); // максимально число пассажиров
}
// "Запорожец" - это: транспортное средство с колесами, существующее
// в материальном мире.
class Zaporojets implements ITransport, IWheeled, IWorldObject {
  private $coordArray;
  public function getCoord() { return $coordArray; }
  public function getNumWheels() { return 4; }
  public function getNumPassengers() { return 16; }
  // Также нужно определить конструктор, деструктор и другие методы.
}
?>
