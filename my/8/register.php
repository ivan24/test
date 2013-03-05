<?php
require_once('./strategy.php');

class RegistrationMqr
{
    function register(Lesson $lesson)
    {
        $notifier = Notifier::getNotifier();
        $notifier->info();
    }
}
abstract class Notifier
{
    static function getNotifier(){
        if( rand(1,2) == 1) {
            return new MailNotifier();
        }else{
            return new TextNotifier();
        }
    }
    abstract function info();
}
class MailNotifier extends Notifier
{
    function info(){
        print "Уведомление по E-mail";
        print "<hr>";
    }
}
class  TextNotifier extends Notifier
{
    function info(){
        print "Уведомление текстовое!!";
        print "<hr>";
    }
}
$seminar = new Seminar(4,new TimedCostStrategy());
$lecture = new Lecture(4,new FixedCostStrategy());
$mqr = new RegistrationMqr();
$mqr->register($seminar);
$mqr->register($lecture);