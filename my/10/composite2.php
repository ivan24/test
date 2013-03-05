<?php
abstract class Unit
{
     function addUnit(Unit $unit)
     {
         throw new UnitException(get_class($this)."относится к листьям");
     }

     function removeUnit(Unit $unit)
     {
         throw new UnitException(get_class($this)."относится к листьям");
     }

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

class Army extends Unit
{
    private $units = array();

    function addUnit(Unit $unit)
    {
        if (in_array($unit, $this->units, true)) {
            return;
        }
        $this->units[] = $unit;
    }

    function removeUnit(Unit $unit)
    {
        return array_udiff(
            $this->units,
            array($unit),
            function ($a, $b) {
                return ($a === $b) ? 0 : 1;
            }
        );
    }

    function bombardStrength()
    {
        $res = 0;
        /** @var Unit $unit */
        foreach ($this->units as $unit) {
            $res += $unit->bombardStrength();
        }
        return $res;
    }
}