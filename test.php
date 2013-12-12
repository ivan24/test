<?php
class Login implements SplSubject
{
    const LOGIN_SUCCESS = 1;
    const LOGIN_FAILED = 0;
    private $storage;
    private $status;

    public function __construct()
    {
        $this->storage = new SplObjectStorage();
    }

    public function attach (SplObserver $observer)
    {
        $this->storage->attach($observer);
    }

    public function detach (SplObserver $observer)
    {
        $this->storage->detach($observer);
    }

    public function notify ()
    {
        foreach ($this->storage as $observer) {
            $observer->update($this);
        }
    }

    public function validate()
    {
        switch(mt_rand(1,2)){
            case 1:
                echo "1<br>";
                $this->setStatus(self::LOGIN_SUCCESS);
                break;
            case 2:
                echo "2<br>";
                $this->setStatus(self::LOGIN_FAILED);
                break;
            default:
                echo "default";
        }
        $this->notify();
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }




}

class Logger implements SplObserver
{
    public function update(SplSubject $subject)
    {
        if($subject->getStatus()=== Login::LOGIN_SUCCESS){
            echo "User successfull login";
        } elseif ($subject->getStatus() === Login::LOGIN_FAILED) {
            echo "User doesn't login";
        }

    }
}

$login = new Login();
$login->attach(new Logger());
$login->validate();