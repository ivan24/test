<?php ## Пример использования итераторов: галерея картинок.
// Абстрактный класс: объект файловой системы (директория или файл).
abstract class FilesystemEntry {
  // Путь к объекту.
  public $path;
  // Конструктор.
  public function __construct($path) {
    $this->path = $path;
  }
}

// Картинка.
class Image extends FilesystemEntry {
  // Возвращает информацию об изображении.
  public function getInfo() {
    return getimagesize($this->path);
  }
}

// Галерея (директория с картинками). При итерации возвращает свое содержимое.
class Gallery extends FilesystemEntry implements IteratorAggregate {
  public $ext = array('gif', 'jpg', 'png', 'bmp');
  // Конструктор. Определяет расширения файлов-картинок.
  public function __construct($path, $ext=null) {
    parent::__construct($path);
    if ($ext !== null) $this->ext = $ext;
  }
  // Возвращает итератор - "представителя" данного объекта.
  public function getIterator() {
    return new GalleryIterator($this);
  }
}

class GalleryPage implements IteratorAggregate {
  // Возвращает итератор - "представителя" данного объекта.
  public function getIterator() {
    return new GalleryIterator($this);
  }
}

// Класс-итератор. Является представителем для объектов Directory 
// при переборе содержимого директории.
class GalleryIterator implements Iterator {
  // Ссылка на "объект-начальник".
  private $owner;
  // Имена файлов и директорий в каталоге.
  private $entries = array();
  // Текущий номер элемента при итерации.
  private $n = 0;
  // Конструктор. Инициализирует новый итератор.
  public function __construct($owner) {
    $this->owner = $owner;
    // Функция glob() работает очень быстро, даже если в директории 100000
    // файлов. Это объясняется тем, что атрибуты файлов (вроде размера) не
    // считываются сразу (это происходит позже, по отдельному запросу).
    $this->entries = glob("{$owner->path}/*");
  }
  //*
  //* Далее идут переопределения виртуальных методов интерфейса Iterator.
  //*
  // Сбрасывает итератор на первый элемент.
  public function rewind() {
    $this->n = 0;
  }
  // Проверяет, не закончились ли уже элементы.
  public function valid() {
    return $this->n < count($this->entries);
  }
  // Возвращает текущий ключ.
  public function key() {
    return $this->entries[$this->n];
  }
  // Возвращает текущее значение.
  public function current() {
    $path = $this->entries[$this->n];
    return is_dir($path)? new Gallery($path) : new Image($path);
  }
  // Передвигает итератор к следующему элементу в списке.
  public function next() {
    $this->n++;
  }
}

// Для примера - открываем директорию, в которой много картинок.
$g = new Gallery("C:/windows");
foreach ($g->getPage(0, 20) as $path=>$entry) {
  if ($entry instanceof Image) {
    // Если это - изображение, а не поддиректория...
    echo "<pre>$path: ".print_r($entry->getInfo(), true)."</pre>";
  }
}
?>