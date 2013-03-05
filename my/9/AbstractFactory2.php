<?php
abstract class CommsManager
{
    const APPT = 1;
    const TTD = 2;
    const CONTACT = 3;

    abstract function getHeaderText();

    abstract function getFooterText();

    abstract function make($flag_int);

}

class BlogsCommsManager extends CommsManager
{
    function getHeaderText()
    {
        return "BlogsCall Верхний калонтитур<br>";
    }

    function getFooterText()
    {
        return "BlogsCall нижний калонтитур<br>";
    }

    function make($flag_int)
    {
        switch ($flag_int) {
            case self::APPT:
                return new BloggsApptEncoder();
            case self::TTD:
                return new BlogsTtdEncoder();
            case self::CONTACT:
                return new BlogsContactEncoder();
        }
    }
}