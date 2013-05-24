<?php ## Интерфейс шаблонизатора с обработчиками Apache.
// Save loading time.
define("Subsys_Templier_ApacheHandler_START_TIME", microtime());

require_once "Cache/Site.php";
require_once "Apache/Rewriter.php";

class Subsys_Templier_ApacheHandler
{
  var $VERSION = "1.01";

  var $useHook = true;
  var $useFormPersister = true;
  var $useCookieStat = true;
  var $useGzip = 9;
  var $useRecoder = false;
  var $useLogging = "Subsys_Templier_ApacheHandler.log";
  var $templierClass = false;
  var $cache = null;

  // Constructor.
  function Subsys_Templier_ApacheHandler($templierClass, $tmp="/tmp") {
    $this->templierClass = $templierClass;
    if (!@is_dir($tmp)) $tmp = "./tmp";
    $this->cache = new Cache_Site($tmp);
  }

  // Process current Apache request.
  function processRequest() {
    //**
    //** Check if user has tried to execute handler directly.
    //** URI in browser must not contain path to this script.
    //**
    $fileName = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);
    $reqName  = str_replace(
      "\\", "/",
      preg_Replace("/\\?.*/", "", $_SERVER['REQUEST_URI'])
    );
    if (preg_match('/'.preg_quote($reqName, '/').'$/si', $fileName)) {
      $this->logError("Access denied");
      Apache_Rewriter::doErrorDocument("403");
    }
    // **
    // ** End of request checking.
    // **

    // Handler execution method.
    if (!isset($_SERVER['REDIRECT_REDIRECT_REDIRECT_STATUS']) && @$_SERVER['PATH_INFO']) {
      // Action templhandler "/WEB-INF/TemplierHandler.php"
      $request = $_SERVER["PATH_INFO"] . (
         $_SERVER['QUERY_STRING']!==''?
           "?".$_SERVER['QUERY_STRING'] : ""
      );
    } else {
      // Action templhandler "/WEB-INF/TemplierHandler.php?"
      $request = $_SERVER['QUERY_STRING'];
    }

    // Correct environment & GET variables accorging to request URI.
    Apache_Rewriter::doPseudoRedirect($request, "404");

    // Set OB handlers conveyer.
    if ($this->useHook) {
      if ($this->useCookieStat)
          ob_start(array(&$this, "ob_saveCookieAfter"));
      if ($this->useGzip) 
          ob_start("ob_gzhandler", $this->useGzip);
      if ($this->useCookieStat) 
          ob_start(array(&$this, "ob_saveCookieBefore"));
      if ($this->useFormPersister) {
        require_once "HTML/FormPersister.php";
        ob_start("ob_formpersisterhandler");
      }
    }

    // Run template engine.
    $class = $this->templierClass;
    $tm = new $class("/", $this->cache);
    $result = $tm->runUri($_SERVER['REQUEST_URI']);
    if ($result === null) {
      Apache_Rewriter::doErrorDocument("404");
      return;
    }

    if ($this->useRecoder !== false && $this->useHook) {
      include_once "HTML/Recoder.php";
      $rec = new HTML_Recoder($this->useRecoder);
      $result = $rec->process($result);
    }

    echo $result;
  }

  // Called on hacking attempt.
  function logError($msg) {
    if (!$this->useLogging) return;
    // Logging user info.
    $fn = dirname($_SERVER['SCRIPT_FILENAME'])."/{$this->useLogging}";
    $f = fopen($fn, "a+");
    fputs($f, date("d.m.Y H:i.s ").$this->fetchip()." - $msg\n");
    fclose($f);
  }

  // Just set Cookie page_size_after.
  function ob_saveCookieAfter($s) {
    $tS = explode(" ", Subsys_Templier_ApacheHandler_START_TIME); 
    $tS = $tS[0]+$tS[1];
    $tE = explode(" ", microtime()); 
    $tE = $tE[0]+$tE[1];
    @setcookie("page_size_after", strlen($s));
    @setcookie("page_gentime", $tE - $tS);
    return $s;
  }

  // Just set Cookie page_size_after.
  function ob_saveCookieBefore($s) {
    @setcookie("page_size_before", strlen($s));
    return $s;
  }

  // Fetches "real" user IP.
  function fetchip() {
    // get useful vars:
    $client_ip = isset($_SERVER['HTTP_CLIENT_IP']) ? 
      $_SERVER['HTTP_CLIENT_IP'] : "";
    $x_forwarded_for = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? 
      $_SERVER['HTTP_X_FORWARDED_FOR'] : "";
    $remote_addr = $_SERVER['REMOTE_ADDR'];
    // then the script itself
    if (!empty ($client_ip) ) {
      $ip_expl = explode('.',$client_ip);
      $referer = explode('.',$remote_addr);
      if ($referer[0] != $ip_expl[0]) { 
        $ip = array_reverse($ip_expl); 
        $ret = implode('.',$ip); 
      } 
      else { $ret = $client_ip; };
    } elseif (!empty($x_forwarded_for)) {
      if (strstr($x_forwarded_for,',')) { 
        $ip_expl = explode(',',$x_forwarded_for); 
        $ret = end($ip_expl); 
      } 
      else { 
        $ret = $x_forwarded_for; 
      }
    } else { 
      $ret = $remote_addr; 
    }
    return $ret;
  }
}
?>