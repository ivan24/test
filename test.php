<?php
$arr = unserialize('a:1:{i:0;a:3:{s:4:"file";s:89:"http://images.irondealer.com/dealers/306/56/72828/machines/1886811-635140558333421905.jpg";s:7:"primary";i:0;s:5:"notes";s:11:"First image";}}');
var_dump($arr);
/*$client = new \SoapClient('https://services.ironsolutions.com/SearchDataService/SearchDataService.asmx?WSDL');
$header = new \SoapHeader('http://services.ironsolutions.com', 'AuthHeader',array(
    'Password'=>'kPYVR7BH',
    'Email'=>'webmaster@westernsales.ca',
));

$client->__setSoapHeaders($header);

$inventory_list = $client->__soapCall('GetInventoryList', array())->inventoryList;
file_put_contents(__DIR__.'/arr.php', var_export($inventory_list, true));
// processing dealer info
$dealer = array();*/

