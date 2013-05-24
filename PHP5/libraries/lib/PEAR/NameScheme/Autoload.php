<?php ## Библиотека автозагрузки.
# Библиотека, включающая автоматическую загрузку по требованию 
# неопределенных классов. Имена классов должны удовлетворять
# соглашениям PEAR. Код классов нехободимо располагать в
# директориях и файлах, удовлетворяющих этим же соглашениям.
# После подключения этой библиотеки к программе сервис 
# автозагрузки включается автоматически и сразу же.

# Подключаем используемые модули.
require_once "PHP/Autoload.php";
require_once "PEAR/NameScheme.php";

class PEAR_NameScheme_Autoload {
  # static void classAutoloader(string $classname)
  # Пытается загрузить класс с именем $classname при
  # помощи include_once. В случае неудачи возвращает false.
  static function classAutoloader($classname) {
    $fname = PEAR_NameScheme::name2path($classname);
    # Проверяем, есть ли такой файл. Открываем
    # его с третьим параметром fopen, равным true
    # (использовать include_path).
    if ($f = @fopen($fname, "r", true)) {
      fclose($f);
      return include_once($fname);
    }
    return false;
  }
}

# Регистрируем функцию автозагрузки. Чтобы указать, что
# нужно вызвать статическую функцию класса, передаем массив.
# Это допустимо, т.к. встроенная функция call_user_func() 
# поддерживает такую семантику.
PHP_Autoload::register(array("PEAR_NameScheme_Autoload", "classAutoloader"));
?>