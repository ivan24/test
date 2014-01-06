<?php

namespace Strategy;

abstract class Marker
{
    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    /**
     * @param string $response
     * @return bool
     */
    abstract function mark($response);
}