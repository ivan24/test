<?php
$m = new Memcached();
$m->addServer('localhost', 11211);
$m->set('phpkey', 'phpvalue');
var_dump( $m->get('phpkey'));
var_dump( $m->get('phpkey1'));