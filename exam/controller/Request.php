<?php
namespace Controller;

class Request 
{
    private $properties = array();
    private $feedback = array();

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        if(isset($_SERVER['REQUEST_METHOD'])) {
            $this->properties = $_REQUEST;
            return;
        }
        foreach ($_SERVER['argv'] as $arg) {
            if(strpos($arg, '=')) {
                list($key, $val) = explode("=", $arg);
                $this->setProperties($key, $val);
            }
        }
    }

    public function addFeedback($msg)
    {
        array_push($this->feedback, $msg);
    }

    public function getFeedback()
    {
        return $this->feedback;
    }

    public function getFeedbackString($sep = "\r\n")
    {
        return implode($sep, $this->feedback);
    }

    public function getProperty($key)
    {
        if(isset($this->properties[$key])) {
            return $this->properties[$key];
        }
        return null;
    }

    public function setProperties($key, $value)
    {
        $this->properties[$key] = $value;
    }

} 