<?php
namespace Controller;

use pear2\Pyrus\Developer\CoverageAnalyzer\Web\Exception;

class ApplicationHelper
{
    private static $instance = null;
    private $config = "../config/config.xml";

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
        $this->getOptions();
    }

    public function getOptions()
    {
        $this->ensure(file_exists($this->config), "File doesn't exist");

        $options = simplexml_load_file($this->config);
        $dsn = (string) $options->dsn;
        print "<hr>";
        print $dsn;
        print "<hr>";
        sleep(1);
    }

    private function ensure($exp, $message)
    {
        if (!$exp) {
            throw new Exception($message);
        }
    }
} 