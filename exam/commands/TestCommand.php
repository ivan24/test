<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace Command;

use Controller\Request;

class TestCommand extends Command
{
    function doExecute(Request $request)
    {
        $request->addFeedback("Добро пожаловать! Test Command");
        include (__DIR__."/view/main.php");
    }
} 