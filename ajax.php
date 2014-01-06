<?php
include "./loader.php";
if (isset($_POST['class']) && !empty($_POST['class'])) {
    $ref = new ReflectionClass(trim($_POST['class'], '.php'));
    $fo = new \Iterators\FileReader($ref->getFileName(), $ref->getStartLine() - 2);
    echo $fo->readFile();
} elseif (isset($_POST['file']) && !empty($_POST['file'])) {
    $filePath = __DIR__ . '/app/' . trim($_POST['file']);
    if (file_exists($filePath)) {
        include $filePath;
    } else {
        throw new Exception("$filepath file doesn't exist");
    }
}
