<?php ## Пример неявного использования итератора в foreach.
require_once "lib/config.php"; 
require_once "FS.php";

// Для примера - открываем директорию, в которой много картинок.
$d = new FS_Directory("C:/windows");
foreach ($d as $path=>$entry) {
  if ($entry instanceof FS_File) {
    // Если это - файл, а не поддиректория...
    echo "<tt>$path</tt>: ".$entry->getSize()."<br>";
  }
}
?>