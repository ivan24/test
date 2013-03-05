<?php
abstract class CommsManager
{
    abstract function getHeaderText();

    abstract function getFooterText();

    abstract function getApptEncoder();

    abstract function getTtdEncoder();

    abstract function getContactEncoder();
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

    function getApptEncoder()
    {
        return new BlogsApptEncoder();
    }

    function getContactEncoder()
    {
        return new BlogsContactEncoder();
    }

    function getTtdEncoder()
    {
        return new BlogsTtdEncoder();
    }
}