<?php
class Person
{
    function __get($name)
    {
        $method = "get{$name}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }else{
            return $name.' dosn\'t exist '."\r\n";
        }
    }
    function __isset($name){
        $method = "get{$name}";
        if(method_exists($this, $method)){
            return $this->$method();
        }
        return true;
    }
    function getName()
    {
        return 'Ivan';
    }

    function getAge()
    {
        return '25';
    }
}
$per = new Person();
//print_r($per->Sex);
var_dump(isset($per->sex));
if(isset($per->sex)){
    echo $per->sex;
}
print_r($per->name);