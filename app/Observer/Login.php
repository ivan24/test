<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace Observer;

use SplObserver;

class Login implements \SplSubject
{
    const LOGIN_FAILED = 1;
    const LOGIN_SUCCESS = 2;
    const LOGIN_DEFAULT = 3;

    private $storage;
    private $status = [];

    public function __construct()
    {
        $this->storage = new \SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
       $this->storage->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->storage->detach($observer);
    }

    public function notify()
    {
        /**@var \SplObserver $observer*/
        foreach ($this->storage as $observer) {
            $observer->update($this);
        }
    }

    /**
     * @param array $status
     */
    public function setStatus(array $status)
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function handleLogin()
    {
        $result = false;
        switch (mt_rand(1, 3)) {
            case self::LOGIN_SUCCESS :
                echo "status LOGIN_SUCCESS ";
                $this->setStatus([
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'time' => date('H:i:s', time()),
                    'status' => self::LOGIN_SUCCESS
                ]);
                $result = true;
                break;

            case self::LOGIN_FAILED :
                echo "status LOGIN_FAILED ";
                $this->setStatus([
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'time' => date('H:i:s', time()),
                    'status' => self::LOGIN_FAILED
                ]);
                break;
            default :
                echo "status LOGIN_DEFAULT ";
                $this->setStatus([
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'time' => date('H:i:s', time()),
                    'status' => self::LOGIN_DEFAULT
                ]);;
        }
        $this->notify();
        return $result;
    }
}