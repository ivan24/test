<?php ## Открытые и закрытые члены модуля.
class test {
  # Скрытая переменная.
  private static $v = 10;

  # Общедоступная функция.
  public static function pub() { 
    echo "public (v=".self::$v.")<br>"; 
    self::pri("вызов изнутри класса");
  }
  # Скрытая функция.
  private static function pri($from) { 
    echo "private $from<br>"; 
  }
}

test::pub();
test::pri("снаружи");
?>