<?php
namespace Three;

use PhpAmqpLib\Connection\AMQPConnection;


require_once '../../php-amqplib/vendor/autoload.php';
$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('logs', 'fanout', false, false, false);
list($queueName, ,) = $channel->queue_declare('', false, false, true, false);

$channel->queue_bind($queueName, 'logs');

print ' [*] Waiting for logs. To exit press CTRL+C';


$callback = function ($msg) {
    print " [x] Received $msg->body \n";
};
//($queue="", $consumer_tag="", $no_local=false,
//                                  $no_ack=false, $exclusive=false, $nowait=false,
//                                  $callback=null, $ticket=null)
$channel->basic_consume($queueName, '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}
$connection->close();
$channel->close();