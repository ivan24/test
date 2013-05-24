<?php ## MVC. Модель (ядро) гостевой книги.
// Загружает гостевую книгу с диска. Возвращает содержание книги.
function LoadBook($fname) {
  if (!file_exists($fname)) return array();
  $Book = unserialize(file_get_contents($fname)); 
  return $Book;
}
// Сохраняет содержимое книги на диске.
function SaveBook($fname, $Book) {
  file_put_contents($fname, serialize($Book));
}
?>