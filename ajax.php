<?php
include "./loader.php";
if (isset($_POST['file']) && !empty($_POST['file'])) {
    $filePath = __DIR__ . '/app/' . trim($_POST['file']);
    if (file_exists($filePath)) {
        if (isset($_POST['exec']) && $_POST['exec'] === 'true') {
            include $filePath;
        } else {
            $fileInfo = new SplFileInfo($filePath);
            $fo = new \Iterators\FileReader($fileInfo->getPathname(), 0);
            echo htmlentities($fo->readFile());
        }
    } else {
        throw new Exception("$filepath file doesn't exist");
    }
}
