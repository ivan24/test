<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace Observer;

abstract class LoginObserver implements \SplObserver
{
    protected $login;
    public function __construct(Login $login)
    {
        $this->login = $login;
        $this->login->attach($this);
    }

    public function update(\SplSubject $subject)
    {
        if($this->login === $subject) {
            $this->doUpdate($subject);
        }
    }
    abstract public function doUpdate(Login $login);
} 