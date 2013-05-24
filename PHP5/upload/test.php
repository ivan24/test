<?php ## PHP автоматически создает переменные призакачке.
if (@$_REQUEST['doUpload']) 
  echo '<pre>Содержимое $_FILES: '.print_r($_FILES, true)."</pre><hr>";
?>
Выберите какой-нибудь файл в форме ниже:
<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST" enctype="multipart/form-data">
<input type="file" name="myFile">
<input type="submit" name="doUpload" value="Закачать">
</form>