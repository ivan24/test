<!-- Использование данных формы -->
<html><body>
<?php
if ($_REQUEST['login']=="root" && $_REQUEST['password']=="Z10N0101") {
  echo "Доступ открыт для пользователя $_REQUEST[login]";
  // Команда блокирования рабочей станции (работает в NT-системах)
  system("rundll32.exe user32.dll,LockWorkStation");
} else {
  echo "Доступ закрыт!";
}
?>
</html></body>
