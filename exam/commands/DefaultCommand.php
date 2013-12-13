<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace Command;


use Controller\Request;

class DefaultCommand extends Command
{
    function doExecute(Request $request)
    {
        $request->addFeedback("Добро пожаловать! Default Command");
        include (__DIR__."/view/main.php");
    }
} 