<?php ## Анонимные функции и сортировка.
$fruits = array("orange", "apple", "apricot", "lemon");
usort($fruits, create_function('$a,$b', 'return strcmp($b, $a);'));
foreach ($fruits as $key=>$value) echo "$key: $value<br>\n";
?>