<!-- Альтернативный синтаксис if-else. -->
<?if (isset($_REQUEST['go'])):?>
  Привет, <?=$_REQUEST['name']?>!
<?else:?>
  <form action="<?=$_SERVER['REQUEST_URI']?>" method=post>
  Ваше имя: <input type=text name=name><br>
  <input type=submit name=go value="Отослать!">
<?endif?>
