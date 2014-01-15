<?php
include __DIR__."/function.php";
echo "String memory usage test.\n\n";
$base_memory_usage = memory_get_usage();
$base_memory_usage = memory_get_usage();

echo "Start\n";
memoryUsage(memory_get_usage(), $base_memory_usage);
$a = new stdClass();

echo "String value setted\n";
memoryUsage(memory_get_usage(), $base_memory_usage);

unset($a);

echo "String value unsetted\n";
memoryUsage(memory_get_usage(), $base_memory_usage);