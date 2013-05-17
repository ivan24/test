<?php

class Registry
{
    private static $instance;
    private $value = array();

    private function __construct()
    {
    }

    static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getValue($key)
    {
        if (isset($this->value[$key])) {
            return $this->value[$key];
        }
        return null;
    }

    public function setValue($key, $value)
    {
        return $this->value[$key] = $value;
    }


}