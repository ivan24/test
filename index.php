<?php

function getDet($type){
    $arr = array(
        1=>'ba',
        2=>'cw',
        3=>'des',
        4=>'layout',
        5=>'php',
        6=>'qa',
        7=>'seo',
        8=>'mng',
        9=>'adm'
    );
    return $arr[$type];
}
$f= fopen('info.text','r');
$users = array();
$i=0;
while(!feof($f)){
    $pattern = '/(^[0-9]{1,2}\.[0-9]{1,2})(.*)/';
    preg_match($pattern,fgets($f),$matches);
    $users[$i]['row']= substr($matches[1], 0, 1);
    $users[$i]['column']= substr($matches[1], 2, 1);
    $users[$i]['department']= getDet(substr($matches[1], 0, 1));
    $users[$i]['username']=trim(trim( $matches[2],'.'));
    $users[$i]['email']=strtolower(str_replace(' ','.',trim(trim( $matches[2],'.')))).'@itstartuplabs.com';


    $i++;

}
var_export($users);
fclose($f);