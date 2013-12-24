<?php
require_once "PHPUnit/Autoload.php";

class UserStore
{
    private $users = array();

    function addUser($name, $mail, $pass)
    {

        if (isset($this->users[$mail])) {
            throw new Exception(
                "User {$mail} already in the system");
        }

        if (strlen($pass) < 5) {
            throw new Exception(
                "Password must have 5 or more letters");
        }

        $this->users[$mail] = array(
            'pass' => $pass,
            'mail' => $mail,
            'name' => $name
        );
        return true;
    }

    function notifyPasswordFailure($mail)
    {
        if (isset($this->users[$mail])) {
            $this->users[$mail]['failed'] = time();
        }
    }


    function getUser($mail)
    {
        return ($this->users[$mail]);
    }
}
class Validator
{
    private $store;

    public function __construct(UserStore $store)
    {
        $this->store = $store;
    }

    public function validateUser($mail, $pass)
    {
        if (!is_array($user = $this->store->getUser($mail))) {
            return false;
        }
        if ($user['pass'] == $pass) {
            return true;
        }
        $this->store->notifyPasswordFailure($mail);
        return false;
    }
}

class UserStoreTest extends PHPUnit_Framework_TestCase
{
    /** @var $store UserStore */
    private $store;

    public function setUp()
    {
        $this->store = new UserStore();
    }

    public function tearDown()
    {

    }

    public function testGetUser()
    {
        $this->store->addUser('bob williams', 'a@b.com', '12345');
        $user = $this->store->getUser('a@b.com');
        $this->assertEquals($user['name'], 'bob williams');
        $this->assertEquals($user['mail'], "a@b.com");
        $this->assertEquals($user['pass'], '12345');
    }


    public function testAddUserShortPass()
    {
        $this->setExpectedException('Exception');
        $this->store->addUser('bob williams', 'a@b.com', '1');
    }

    public function testAddUserDuplicate()
    {
        try {
            $this->store->addUser('bob williams', 'a@b.com', '12345');
            $this->store->addUser('bob stevens', 'a@b.com', '12345');
            self::fail("Exception must be there");
        } catch (Exception $e) {
            $const = $this->logicalAnd(
                $this->logicalNot($this->contains('bob stevens')),
                $this->isType('array')
            );
           $this->assertThat($this->store->getUser("a@b.com"), $const);
        }
    }
}

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    /** @var $validator Validator */
    private $validator;

    public function setUp()
    {
        $store = new UserStore();
        $store->addUser('bob williams', 'a@b.com', '12345');
        $this->validator = new Validator($store);
    }

    public function tearDown()
    {

    }

    public function testValidateFalsePass()
    {
        $store = $this->getMock("UserStore");

        $this->validator = new Validator($store);

        $store->expects($this->once())
            ->method('notifyPasswordFailure')
            ->with($this->equalTo('bob@example.com'));

        $store->expects($this->any())
            ->method("getUser")
            ->with($this->returnValue(array(
                "name" =>"bob@example.com",
                "pass" => "right"
            )));

        $this->validator->validateUser("bob@example.com", "wrong");
    }

    public function testValidateCorrectPass()
    {
        $this->assertEquals(
            $this->validator->validateUser('a@b', '12345'),
            "Expecting successful validation"
        );
    }
}