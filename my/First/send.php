<?php
namespace First;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once '../../php-amqplib/vendor/autoload.php';

$connection = new AMQPConnection('localhost',5672,'guest','guest');
$channel = $connection->channel();
$channel->queue_declare('ivanTest');
$msg = new AMQPMessage('Hello world');
$channel->basic_publish($msg,'','ivanTest');
print " [x] Sent $msg->body\n";
$channel->close();
$connection->close();
