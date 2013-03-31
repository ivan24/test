<?php
namespace Three;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once '../../php-amqplib/vendor/autoload.php';
$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('logs', 'fanout', false, false, false);

$message = implode(' ', array_slice($argv, 1));
if (empty($message)) {

    $random = mt_rand(0, 4);
    $message = "Message ";
    for ($i = 0; $i <= $random; $i++) {
        $message .= '.';
    }
    print " [->] Generate random message $message \n";
}


$msg = new AMQPMessage($message);
print " [x] Sent $msg->body\n";

$channel->basic_publish($msg, 'logs');

$channel->close();
$connection->close();