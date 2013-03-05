<?php
class Singleton
{
    private $props = array();

    public function getProps()
    {
        return $this->props;
    }
    private static $instance;

    private function __construct()
    {
    }

    static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function setProp($key, $value)
    {
        $this->props[$key] = $value;
    }

    public function getProp($key)
    {
        return $this->props[$key];
    }

}
$fc = FrontController::getInstance();
$fc->setProp('name','ivan');
unset($fc);
$fc2 = FrontController::getInstance();
$fc2->setProp('second','rockonline');
print $fc2->getProp('name');
var_dump($fc2->getProps());