<?php
abstract class DomainObject
{
    private $group;
    public function __costruct()
    {
        $this->group = static::getGroup();
    }
    public static function getGroup()
    {
        return 'default';
    }
    public static function create()
    {
        return new static();
    }
}
class User extends DomainObject{}
class Document extends DomainObject
{
    static function getGroup()
    {
        return 'documment';
    }
}
class SpreadSheet extends Document{}
print_r(User::create());
print_r(SpreadSheet::create());