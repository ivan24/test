<?php
/**@author Ivan Oreshkov ivan.oreshkov@gmail.com */

namespace Iterators;

class MyIteratableClass implements \IteratorAggregate
{
    protected $arr = [];

    public function __construct()
    {
        $this->arr = range(0, 10);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->arr);
    }
}


