<?php
class Person
{
    private $writer;
    function __construct(PersonWriter $writer)
    {
        $this->writer = $writer;
    }

    function __call($methodname, $arg)
    {
        if (method_exists($this->writer, $methodname)) {
            return $this->writer->$methodname($arg);
        }
    }

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
class PersonWriter
{
    function tets($arg)
    {
        var_dump($arg);
        echo "<hr>";
        echo __FUNCTION__,__CLASS__;
    }
}
$per = new Person(new PersonWriter());

$per->tets('ivam');