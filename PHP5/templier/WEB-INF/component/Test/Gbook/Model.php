<?php ## Модель гостевой книги.
class Test_Gbook_Model {
  // Загружает гостевую книгу с диска. Возвращает содержание книги.
  function load($name) {
    $fname = "data/$name.dat";
    @mkdir(dirname($fname));
    if (!file_exists($fname)) return array();
    $Book = unserialize(file_get_contents($fname)); 
    return $Book;
  }
  // Сохраняет содержимое книги на диске.
  function save($name, $Book) {
    $fname = "data/$name.dat";
    $f = fopen($fname, "w");
    fwrite($f, serialize($Book));
    fclose($f);
  }
}
?>