<?php
for($i = 0; $i < 1000; $i++) {
    echo var_dump($_SERVER);
}
file_put_contents(__DIR__."/test.txt", "1\r\n",FILE_APPEND);