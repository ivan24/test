<?php ## ������� �������������� �������.
$birth = array(
  "Thomas Anderson" => "1962-03-11",
  "Keanu Reeves"    => "1962-09-02",
);
for (reset($birth); ($k=key($birth)); next($birth))
  echo "$k ������� {$birth[$k]}<br>";
?>