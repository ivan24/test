<?php ## "Ручная" реализация наследования.
// Вначале подключаем "базовый" класс.
require_once "File/Logger.php";
// Класс, добавляющий в File_Logger новую функциональность.
class File_Logger_Debug0 {
  // Объект "базового" класса File_Logger.
  private $logger; 
  // Конструктор нового класса. Создает объект File_Logger.
  public function __construct($name, $fname) { 
    $this->logger = new File_Logger($name, $fname);
    // Здесь можно проинициализировать другие свойства текущего
    // класса, если они будут.
  }
  // Добавляем новый метод.
  public function debug($s, $level=0) {
    $stack = debug_backtrace();
    $file = basename($stack[$level]['file']);
    $line = $stack[$level]['line'];
    $this->logger->log("[at $file line $line] $s");
  }
  // Оставляем на месте старый метод log().
  public function log($s) { return $this->logger->log($s); }
  // И такие методы-посредники мы должны создать ДЛЯ КАЖДОГО
  // метода из File_Logger.
}
?>