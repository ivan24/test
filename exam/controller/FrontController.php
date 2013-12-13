<?php
namespace Controller;

use Command\CommandResolver;

$start = microtime(true);

class FrontController
{
    private $applicationHelper;

    private function __contstruct()
    {
    }

    public static function run()
    {
        header('content-type:text/html;charset=utf8');
        $instance = new self();
        $instance->init();
        $instance->handleRequest();
    }

    public function init()
    {
        $this->applicationHelper = ApplicationHelper::getInstance();
        $this->applicationHelper->init();
    }

    public function handleRequest()
    {
        $request = new Request();
        $cmd_r = new CommandResolver();
        $cmd = $cmd_r->getCommand($request);
        $cmd->execute($request);
    }
}

require_once __DIR__."/ApplicationHelper.php";
require_once __DIR__."/Request.php";
require_once __DIR__."/../commands/CommandResolver.php";
FrontController::run();
$time = microtime(true) - $start;
printf('<hr>Скрипт выполнялся %.4F сек.<hr>', $time);