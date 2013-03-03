<?php

class Account
{
    public $balance;

    function __construct($balance)
    {
        $this->balance = $balance;
    }

}

class Person
{
    private $name;
    private $age;
    private $id;
    public $account;


    function __construct($account, $age, $name)
    {
        $this->account = $account;
        $this->age = $age;
        $this->name = $name;
    }

    function __destruct()
    {
        if (!empty($this->id)) {
            print "saving person \n";
        }
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    function __clone()
    {
        $this->id = 0;
        $this->name = 'Clone';
        $this->age = 'newbaby';
        $this->account = clone $this->account;
    }

}

$person = new Person(new Account(200), 'Ivan', 25);
$person->setId(1);
$clone = clone $person;
$person->account->balance += 10;
var_dump($clone, $person);
unset($person);
