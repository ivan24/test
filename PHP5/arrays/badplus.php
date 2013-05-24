<?php ## Неправильное слияние списков.
$good = array("Julian Arahanga", "Matt Doran", "Belinda McClory");
$bad = array("Paul Goddard", "Robert Taylor");
$ugly = array("Clint Eastwood");
$all = $good + $bad + $ugly;
print_r($all);
?>