<?php
class Loader
{
    protected static $instance = null;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    protected function load($className)
    {
        $className = ltrim($className, '\\');
        $fileName = __DIR__ . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR;
        if ($lastNs = strrpos($className, '\\')) {
            $namecpace = substr($className, 0, $lastNs);
            $className = substr($className, $lastNs + 1);
            $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namecpace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className . '.php');
        require $fileName;
    }

    /**
     * @return Loader
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
            spl_autoload_register(array(self::$instance, 'load'));
        }
        return self::$instance;
    }

}

class GreaterThenThreeFilterIterator extends FilterIterator
{
    public function accept()
    {
        return ($this->current() > 3 && $this->current() < 8);
    }
}

$loader = Loader::getInstance();



