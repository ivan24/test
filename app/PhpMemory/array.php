<?php
include __DIR__."/function.php";
echo "Array memory usage example.".PHP_EOL;
$base_memory_usage = memory_get_usage();
$base_memory_usage = memory_get_usage();

echo 'Base usage.'.PHP_EOL;
memoryUsage(memory_get_usage(), $base_memory_usage);

$a = array(someBigValue(), someBigValue(), someBigValue(), someBigValue());

echo 'Array is set.'.PHP_EOL;
memoryUsage(memory_get_usage(), $base_memory_usage);

foreach ($a as $k=>&$v) {
    $a[$k] = someBigValue(); // Или $v = someBigValue();
    unset($k, $v);
    echo 'In FOREACH cycle.'.PHP_EOL;
    memoryUsage(memory_get_usage(), $base_memory_usage);
}

echo 'Usage right after FOREACH.'.PHP_EOL;
memoryUsage(memory_get_usage(), $base_memory_usage);
