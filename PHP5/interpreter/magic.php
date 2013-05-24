<?php ## Иллюстрация нехороших качеств magic_quotes_gpc.
// Делаем что-нибудь, если нажата кнопка Go!
if (!isset($_REQUEST['name'])) 
  $_REQUEST['name'] = 'Значение "по умолчанию"';
?>
<form action="<?=$_SERVER['SCRIPT_NAME']?>">
<input type="text" name="name" size="40"
  value="<?=htmlspecialchars($_REQUEST['name'])?>"> 
<input type="submit" name="submit" value="Go!">
</form>
