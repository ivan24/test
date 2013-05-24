<?php ## ќсобенности global.
$a = 100;
function test() { 
  global $a;
  unset($a);
}
test();
echo $a;  // выводит 100, т. е. насто€ща€ $a не была удалена в test()!
?>
