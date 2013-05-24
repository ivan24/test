<?php ## »зменение элементов при переборе.
$numbers = array(100, 313, 605);
foreach ($numbers as &$v) $v++;
echo "Ёлементы массива: ";
foreach ($numbers as $elt) echo "$elt ";  
?>
