<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

abstract class Command
{
    abstract public function execute(CommandContext $command);
}

class LoginCommand extends Command
{
    public function execute(CommandContext $command)
    {
        var_dump($command);
        $pass = $command->getParam('pass');
        $user = $command->getParam('username');
        echo "<br>";
        echo $pass." ".$user;
        echo "<br>";
        echo __CLASS__." ----> ".__FUNCTION__."<br>";
    }
}

class CommandContext
{
    private $params = array();
    private $error = "";

    function __construct()
    {
        $this->params = $_REQUEST;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getParam($key)
    {
        return $this->params[$key];
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }
}

class Controller
{
    private $context;

    public function __construct()
    {
        $this->context = new CommandContext();
    }

    /**
     * @return CommandContext
     */
    public function getContext()
    {
        return $this->context;
    }

    public function process()
    {
        $cmd = CommandFactory::getCommand($this->context->getParam('action'));
        if(!$cmd->execute($this->context)){
            echo "ERROR";
        } else {
            echo "SUCCESS";
        }
    }

}

class CommandFactory
{
    public static function getCommand($action)
    {
        if(preg_match('/\W/',$action)){
            throw new Exception("Heдопустимые символы");
        }
        $class = ucfirst(strtolower($action))."Command";
        $cmd = new $class();
        return $cmd;
    }
}
$controller = new Controller();
$context = $controller->getContext();
$context->addParam('action','login');
$context->addParam('username', 'bob');
$context->addParam('pass','meggaPassword');
$controller->process();