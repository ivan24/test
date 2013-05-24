<?php ## Компонент добавления записи в гостевую книгу.
require_once "Test/Gbook/Model.php";  // подключаем Модель (ядро)

class Test_Gbook_Add extends Subsys_Templier_Component {
  var $NEW_ELEMENT = "new";
  // Компонент возвращает.
  function main($params, &$templier) {
    // Получаем значение параметра, переданного из Шаблона.
    $name = isset($params['book'])? $params['book'] : null;
    if (!$name) {
      $this->croak("parameter 'book' is not specified");
      return false;
    }
    // Если Компонент запущен после нажатия кнопки Добавить...
    if (!empty($_REQUEST['doAdd'])) {
      $new = $_REQUEST[$this->NEW_ELEMENT];
      $new['stamp'] = time();
      // Проверка ошибок.
      $errors = $this->validate($new);
      if ($errors) return $errors;
      // Добавляем запись.
      $Book = Test_Gbook_Model::load($name);
      $Book = array(time() => $new) + $Book;
      Test_Gbook_Model::save($name, $Book);
      // Записываем в Cookie данные посетителя (за исключением текста).
      unset($new['text']); unset($new['stamp']);
      SetCookie("gbook", serialize($new), time()+3600*24*365, "/");
      // Выполняем самопереадресацию.
      Header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['SCRIPT_NAME']}?".time());
      exit();
    } else {
      // Если кнопка не нажата, заполняем форму предыдущими значениями.
      $data = @unserialize($_COOKIE['gbook']);
      $_POST[$this->NEW_ELEMENT] = $data;
      // Эти данные появятся в INPUT-полях страницы автоматически -
      // об этом позаботится библиотека HTML_FormPersister.
    }
    // Ошибок нет.
    return array();
  }

  // Проверяет допустимость новой записи.
  function validate(&$new) {
    $errors = array();
    if (!trim($new['name'])) {
      $errors['name'] = true;
    }
    if (!trim($new['email'])) {
      $errors['email'] = true;
    }
    if (!trim($new['occupation'])) {
      $errors['occupation'] = true;
    }
    if (!trim($new['text'])) {
      $errors['text'] = true;
    }
    return $errors;
  }
}
?>