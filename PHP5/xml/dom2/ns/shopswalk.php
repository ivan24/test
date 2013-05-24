<?php ## Программа обхода торговых точек (shopswalk.php)
require_once 'unicode.inc';
require_once "wallet.class";
require_once "order.class";
require_once "shops.class";

$wallet=new wallet();
$order=new order();
$shops=new shops($argv[1]);//получить бумажник, заказ и список магазинов

$shops->walk($order,$wallet);//пройтись по магазинам

//сохранить новое состояние бумажника, заказа и магазинов
$wallet->save();
$order->save();
$shops->save();
?>
