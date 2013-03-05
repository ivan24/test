<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ivan Oreshkov ivan.oreshkov@itstaruplabs.com
 * Date: 05.03.13
 * Time: 14:31
 * To change this template use File | Settings | File Templates.
 */
abstract class Unit{
    abstract function bombardStrength();
}
class Archer extends Unit
{
    function bombardStrength()
    {
        return 4;
    }
}

class LaserCannonUnit extends Unit
{
    function bombardStrength()
    {
        return 44;
    }
}
class Army
{
    private $units = array();
    function addUnit(Unit $unit)
    {
        array_push($this->unit,$unit);
    }
    function bombardStrength()
    {
        $res = 0;
        /** @var Unit $unit */
        foreach($this->units as $unit) {
         $res += $unit->bombardStrength();
    }
        return $res;
    }
}