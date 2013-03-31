<?php
#!/usr/bin/env php

namespace Second;

use PhpAmqpLib\Connection\AMQPConnection;

require_once '../../php-amqplib/vendor/autoload.php';

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();


$queue = "Second";
$channel->queue_declare($queue, false, true, false, false);

$callback = function ($msg) {
    /** @var \PhpAmqpLib\Message\AMQPMessage $msg*/
    $count = substr_count($msg->body, '.');
    print " [x] Receive $msg->body and sleep $count\n";
    sleep($count);
    print " [x] Done\n";
    // потверждени обработки сообщения
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

};

$channel->basic_qos(null, 1, null);
$channel->basic_consume($queue, '', false, false, false, false, $callback);
print " [*] Waiting for messages. To exit press CTRL+C \n";
while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
