<?php
abstract class ApptEncoder
{
    abstract function encode();
}
class BlogsApptEncoder extends ApptEncoder
{
    function encode()
    {
        return "Данный о встрече закодированы в формате BloggsCal <br>";
    }
}
class MeggaApptEncoder extends ApptEncoder
{
    function encode()
    {
        return "Данный о встрече закодированы в формате MeggaCalls <br>";
    }
}
abstract class CommsManager
{
    abstract function getHeaderText();
    abstract function getAppEncoder();
    abstract function getFooterText();
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
    function getAppEncoder()
    {
        return new BlogsApptEncoder();
    }
}
class MeggaCommsManager extends CommsManager
{
    function getHeaderText()
    {
        return "MeggaCall Верхний калонтитур<br>";
    }
    function getFooterText()
    {
        return "MeggaCall нижний калонтитур<br>";
    }
    function getAppEncoder()
    {
        return new MeggaApptEncoder();
    }
}