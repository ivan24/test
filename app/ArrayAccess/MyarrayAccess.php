<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace ArrayAccess;


class MyarrayAccess implements \ArrayAccess
{
    private $arr = [];

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->arr);
    }

    public function offsetGet($offset)
    {
        return $this->arr[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->arr[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
       unset($this->arr[$offset]);
    }
}