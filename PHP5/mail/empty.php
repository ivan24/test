<?php ## Пустые параметры: ошибочный результат!
mail(
  false, false, "I suppose you've been expecting me, right?", 
  "To: somebody@mail.ru\r\nSubject: Hello"
);
?>