<?php ## Автоматическая вставка SID в ссылки.
ini_set("session.use_trans_sid", true);
session_start();
?>
<body>
<a href=/path/to/something.html>Click here!</a><br>
<a href=/path/to/something.php?param=value>Click here!</a><br>
<a href=http://thematrix.com/>Click here!</a><br>
</body>