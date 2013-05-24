<?php ## Скрипт, имеющий уязвимость в защите.
die("Уберите эту строчку, если действительно хотите запустить скрипт!");
if ($type = @$_REQUEST['type']) {
  $fname = "$type.txt";
  if ($f = @fopen($fname, "r")) {
    $content = fread($f, filesize($fname));
  }
}
?>
<html>
<body>
  <form name="<?php echo $_ENV["SCRIPT_NAME"]?>">
    Показать: 
    <select name="type">
      <option value="site">новости сайта</option>
      <option value="world">мировые новости</option>
      <option value="weather">прогноз погоды</option>
    </select><br/>
    <input type=submit value="Просмотреть новости" />
  </form>
  <?php if (@$content) echo "<hr/>$content" ?>
</body>
</html>