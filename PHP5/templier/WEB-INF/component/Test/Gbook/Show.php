<?php ## Компонент показа гостевой книги.
require_once "Test/Gbook/Model.php";  // подключаем Модель (ядро)

class Test_Gbook_Show extends Subsys_Templier_Component {
  // Точка входа Компонента.
  function main($params, &$templier) {
    // Получаем значение параметра, переданного из Шаблона.
    $name = isset($params['book'])? $params['book'] : null;
    if (!$name) {
      $this->croak("parameter 'book' is not specified");
      return false;
    }
    $Book = Test_Gbook_Model::load($name);
    return $Book;
  }
}
?>