<?php
namespace First;

use PhpAmqpLib\Connection\AMQPConnection;

require_once '../../php-amqplib/vendor/autoload.php';

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('ivanTest');

$callback = function ($msg) {
    print " [x] Received $msg->body \n";
};
//($queue="", $consumer_tag="", $no_local=false,
//                                  $no_ack=false, $exclusive=false, $nowait=false,
//                                  $callback=null, $ticket=null)
$channel->basic_consume('ivanTest', '', false, true, false, false, $callback);

print ' [*] Waiting for messages. To exit press CTRL+C';
while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();