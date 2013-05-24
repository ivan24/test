<?php ## ѕример библиотеки.
class TestLib {
  const POW = 2;               # константа библиотеки
  static $sumLength = 0;       # переменна€ библиотеки
  static function length($s) { # функци€ библиотеки
    $len = strlen($s);
    self::$sumLength += $len;
    return $len; 
  }
  static function poweredLength($s) {
    $len = self::length($s);
    return pow($len, self::POW); # возведение в степень
  }
}
?>