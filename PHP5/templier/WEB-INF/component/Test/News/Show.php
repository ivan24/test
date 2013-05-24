<?php ## Компонент показа новостей.
class Test_News_Show extends Subsys_Templier_Component {
  // Точка входа Компонента.
  function main($params, &$templier) {
    // Получаем значение параметра, переданного из Шаблона.
    $file = isset($params['file'])? $params['file'] : null;
    if (!$file) {
      $this->croak("parameter 'file' is not specified");
      return false;
    }
    $num  = isset($params['num'])? $params['num'] : 5;
    // Подгружаем данные $num новостей с диска. Вообще говоря,
    // этой работой должна заниматься Модель новостей, однако для
    // экономии места мы размещаем код непосредственно в Компоненте.
    $result = array();
    $f = @fopen($file, "r");
    if (!$f) {
      $this->croak("could not find $file");
      return false;
    }
    for ($i=0; !feof($f) && $i < $num; $i++) {
      $n = trim(fgets($f, 1024));
      if (!$n) continue;
      list ($date, $text) = preg_split('/\s+/', $n, 2);
      $result[] = array(
        'date' => $date,
        'text' => $text,
      );
    }
    // Компонент должен просто вернуть результат своей работы.
    return $result;
  }
  // Здесь могут быть и другие (вспомогательные) методы.
}
?>