<?php ## Пример работы с сессиями.
header('Content-type:text/html;charset=utf8');
class Session {

        protected $_namespace = 'acax';

        public function __construct($namespace = null) {
            if(!session_id() && 'cli' != PHP_SAPI) {
                session_set_cookie_params('','/');
                session_start();
            }

            if (!is_null($namespace)) {
                $this->_namespace = (string)$namespace;
            }
        }

        public function __isset($name) {
            return isset($_SESSION[$this->_namespace][$name]);
        }

        public function __get($name) {
            return (isset($_SESSION[$this->_namespace][$name]) ? $_SESSION[$this->_namespace][$name] : null);
        }

        public function __set($name, $value) {
            $_SESSION[$this->_namespace][$name] = $value;
            return true;
        }

        public function clear() {
            $_SESSION[$this->_namespace] = array();
        }

        public function start() {
            session_start();
        }

        public function writeClose() {
            session_write_close();
        }
    }

$a = new Session();

class A {
    protected $session = null;
    protected  $name = "leadInfo";
    function __construct()
    {
        $this->session = new Session();
    }
    function setValue($key,$value)
    {
        $sessionData = $this->session->{$this->name};
        $sessionData[$key] = $value;
        $this->session->{$this->name} = $sessionData;

    }
    function getValues($name)
    {
        return $this->session->{$this->name}[$name];
    }
}
$a = new A();
if (!isset($i)){
    $i = '3aaaaa';
}
$i = $a->getValues('key')+1;
$a->setValue('key',$i);
var_dump($_SESSION);
?>
<h2>Счетчик</h2>
В текущей сессии работы с браузером Вы открыли эту страницу
<?= $a->getValues('key');?> раз(а).<br>
Закройте браузер, чтобы обнулить счетчик.<br>
<a href="<?=$_SERVER['SCRIPT_NAME']?>" target="_blank">Открыть дочернее окно браузера</a>.