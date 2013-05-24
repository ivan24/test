<?php ## Контроллер, использующий Smarty.
require_once "../WEB-INF/lib/config.php";
require_once "Subsys/Smarty/libs/Smarty.class.php";
// Подгружаем данные новостей с диска.
$Data = array();
$f = fopen("news.txt", "r");
for ($i=0; !feof($f); $i++) {
  $n = trim(fgets($f, 1024));
  if (!$n) continue;
  list ($date, $text) = preg_split('/\s+/', $n, 2);
  $Data[] = array(
    'date' => $date,
    'text' => $text,
  );
}
// Инициализируем Smarty.
$smarty = new Smarty();
$smarty->compile_dir = "/tmp";
// Добавляем переменную, которая будет доступна в Шаблоне.
$smarty->assign("news", $Data);
// Запускаем шаблон.
$smarty->display("news.tpl");
?>