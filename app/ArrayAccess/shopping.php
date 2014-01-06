<?php
$cart = new \ArrayAccess\Cart();
$cart[] = new \ArrayAccess\Product(1, 10.99, 'Shoes');
$cart[] = new \ArrayAccess\Product(1, 1.99, 'Book');
$cart[] = new \ArrayAccess\Product(1, 599.99, 'iPad');
var_dump($cart->getCommonPrice());
var_dump($cart);