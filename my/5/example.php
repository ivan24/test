<?php
class Person
{
    public $name;

    function __construct($name)
    {
        $this->name = $name;
    }
}

interface Module
{
    function execute();
}

class FtpModule implements Module
{
    function setHost($host)
    {
         print "FtpModule::setHost() $host";
    }

    function execute()
    {
        //
    }

    function setUser($user)
    {
         print "FtpModule::setUser() $user";
    }
}

class PersonModule implements Module
{
    function setPerson(Person $person)
    {
        print __METHOD__ . " " . $person->name;
    }

    function execute()
    {
        //
    }
}

class ModuleRunner
{
    private $config = array(
        'PersonModule' => array('person' => 'Ivan'),
        'FtpModule' => array(
            'host' => 'example.com',
            'user' => 'User'
        )
    );
    private $modules = array();

    function init()
    {
        $interface = new ReflectionClass('Module');
        foreach ($this->config as $modulename => $params) {
            $module_class = new ReflectionClass($modulename);
            if (!$module_class->isSubclassOf($interface)) {
                throw new Exception("Неизвестный тип модуля: " . $modulename);
            }

            $module = $module_class->newInstance();
            foreach ($module_class->getMethods() as $method) {
                $this->handleMethod($module, $method, $params);
            }
            array_push($this->modules, $module);
        }
    }

    function handleMethod(Module $module, ReflectionMethod $method, $params)
    {
        $name = $method->getName();
        $args = $method->getParameters();
        if (count($args) != 1 || substr($name, 0, 3) != "set") {
            return false;
        }
        $property = strtolower(substr($name, 3));

        if (!isset($params[$property])) {
            return false;
        }

        $arg_class = $args[0]->getClass();
        print "\n";
        if (empty($arg_class)) {
            $method->invoke($module, $params[$property]);
        } else {
            $method->invoke($module, $arg_class->newInstance($params[$property]));
        }

    }
}

$a = new ModuleRunner();
$a->init();