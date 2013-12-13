<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace Command;


use Controller\Request;

abstract class Command
{
    final function __construct()
    {
    }

    public function execute($request)
    {
        $this->doExecute($request);
    }

    abstract public function doExecute(Request $request);
}