<?php
header("Content-type:text/html;charset=utf8");
abstract class Lesson
{
    private $duration;
    private $costStrategy;

    function __construct($duration, CostStrategy $costStrategy)
    {
        $this->costStrategy = $costStrategy;
        $this->duration = $duration;
    }
    function cost()
    {
        return $this->costStrategy->cost($this);
    }
    public function getDuration()
    {
        return $this->duration;
    }
    function chargeType()
    {
        return $this->costStrategy->chargeType();
    }
}

class Lecture extends Lesson
{
}

class Seminar extends Lesson
{
}

abstract class CostStrategy
{
    abstract function cost(Lesson $lesson);

    abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy
{
    function cost(Lesson $lesson)
    {
        return ($lesson->getDuration() * 5);
    }

    function chargeType()
    {
        return "Почасовая оплата";
    }
}

class FixedCostStrategy extends CostStrategy
{
    function cost(Lesson $lesson)
    {
        return 30;
    }

    function chargeType()
    {
        return "Фиксированная ставка";
    }
}
//$lessons[]= new Seminar(4,new TimedCostStrategy());
//$lessons[]= new Lecture(4,new FixedCostStrategy());
//foreach ($lessons as $lesson) {
//    print "Оплата за занатие {$lesson->cost()}<br>";
//    print "Тип занятия {$lesson->chargeType()}<br>";
//    print "<hr>";
//}