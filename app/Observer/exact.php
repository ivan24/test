<?php
$login = new \Observer\Login();
new \Observer\LogFailedLogin($login);
$login->handleLogin();