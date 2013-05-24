<?php ## Пример головного файла скрипта.
class script {
  # Основная функция программы. Запускается при старте скрипта.
  static function main() {
    $start = self::microtime();
    sleep(1);
    echo "Параметр test: ".@$_REQUEST['test'];
    $end = self::microtime();
    echo "<hr>Программа работала ".sprintf("%.2f", $end-$start)." с";
  }

  # double microtime()
  # Возвращает текущее время в секундах в виде ДЕЙСТВИТЕЛЬНОГО 
  # числа (с долями секунды). Заменяет стандартную microtime(),
  # возвращающую массив, с которым не очень удобно работать.
  private static function microtime() {
    $t = explode(" ", microtime());
    return $t[0]+$t[1];
  }
}

if (!defined("DONT_CALL_MAIN")) script::main();
?>