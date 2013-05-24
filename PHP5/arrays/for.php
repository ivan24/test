<?php ## Перебор списка.
$dossier = array(
  array("name"=>"Thomas Anderson", "burn"=>"1962-03-11"),
  array("name"=>"Keanu Reeves",    "burn"=>"1962-09-02"),
);
for($i=0; $i<count($dossier); $i++)
  echo "{$dossier[$i][name]} was burn {$dossier[$i]['burn']}<br>";
?>