<?php
function memoryUsage($usage, $base_memory_usage)
{
    printf("Bytes diff: %d\r\n", $usage - $base_memory_usage);
}

function someBigValue()
{
    return str_repeat('SOME BIG STRING', 1024);
}

function testUsageInside($big_value, $base_memory_usage)
{
    echo 'Usage inside function then $big_value NOT changed.' . PHP_EOL;
    memoryUsage(memory_get_usage(), $base_memory_usage);

    $big_value[0] = someBigValue();
    echo 'Usage inside function then $big_value[0] changed.' . PHP_EOL;
    memoryUsage(memory_get_usage(), $base_memory_usage);

    $big_value[1] = someBigValue();
    echo 'Usage inside function then also $big_value[1] changed.' . PHP_EOL;
    memoryUsage(memory_get_usage(), $base_memory_usage);

}

function getmicrotime()
{
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}