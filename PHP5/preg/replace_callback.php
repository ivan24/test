<?php ## Функция preg_replace_callback() в действии.
// Пользовательская функция. Будет вызываться для каждого
// совпадения с регулярным выражением.
function toUpper($pockets) {
  return $pockets[1].strtoupper($pockets[2]).$pockets[3];
}
$str = '<hTmL><bOdY bgcolor="white">Three captains, one ship.</bOdY></html>';
$str = preg_replace_callback('{(</?)(\w+)(.*?>)}s', "toUpper", $str);
echo htmlspecialchars($str);
?>
