<?php ## явное освобождение ресурсов.
require_once "lib/config.php"; 
require_once "File/Logger0.php";
// —оздаем в цикле много объектов File_Logger0.
for ($n=0; $n<10; $n++) {
  $logger = new File_Logger0("test$n", "test.log");
  $logger->log("Hello!");
  // ѕредставим, что мы случайно забыли вызвать close().
#  $logger->close();
}
?>