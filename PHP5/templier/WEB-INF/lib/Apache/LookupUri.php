<?php
// vim: set expandtab tabstop=4 shiftwidth=4: 
/** 
* apache_lookup_uri wrapper 
* 
* if apache_lookup_uri doesn't exists, it tries to simulate it 
* 
* @author  Ilya Lebedev <ilya_AT_lebedev_DOT_net> 
* @version 0.2 
*/ 
class Apache_LookupUri { 
  var $VERSION = "1.10";
  /** 
   * Wrapper itself 
   * 
   * @param string object for lookup 
   * @return object identical to apache_lookup_uri 
   */ 
  function Apache_LookupUri ($uri) { 
    if (function_exists("apache_lookup_uri") && !defined("Apache_LookupUri_wrapper")) { 
      $l = apache_lookup_uri($uri); 
      foreach ($l as $k => $v) { 
        $this->$k = $v; 
      } 
    } else { 
      $this->method = "GET"; 
      $this->request_time = time(); 
      $this->unparsed_uri = $uri; 
      $this->uri = preg_replace("/\?.*/","",$uri); 
      $this->the_request = "GET ".$uri." HTTP/1.1"; 
      $this->args = preg_replace ("/^.*?(\?)/","",$uri); 
      $res = $this->_parseURI($uri); 
      $this->filename = $res['fname']; 
      $this->path_info = $res['path']; 
      $this->content_type = $res['type']; 
      $this->status = (file_exists($this->filename)?"200":"404"); 
    } 
  } 
  
  // При отсутствии на сервере каталога, но присутствии файла с тем же именем, 
  // с некоторой долей вероятности можно предположить, что используется 
  // режим MultiViews и этот файл является обработчиком запросов из каталога. 
  // Так что, в качестве имени будем возвращать имя обработчика. 
  // 
  // Единственное условие работы - файл должен быть уникальным. 
  // Если файлов несколько, то результатом работы будет первый найденный файл. 

  /** 
   * Parses URI 
   * 
   * @param string URI to parse 
   * @return array 
   */ 
  function _parseURI ($uri) { 
    // 
    // отличительная черта работы MultiViews - передача в 
    // REDIRECT_URL не ссылки на реальный скрипт, а пути в 
    // адресной строке. 
    // 
    $dr = $_SERVER['DOCUMENT_ROOT']; 
    $d = preg_replace("/\?.*/","",$uri); 
    if (file_exists($dr.$d)) { 
      $res[0] = $dr.$d; 
      $p = array(""); 
    } else { 
      $rdr = explode("/",$d); 
      while ($rdr) { 
        $res = glob($dr.implode("/",$rdr).".*"); 
        if (isset($res[0])) break; 
        $p[] = $rdr[sizeof($rdr)-1]; 
        unset ($rdr[sizeof($rdr)-1]); 
      } 
      if (!$res) { 
        $res[0] = $dr.$d; 
        $p = array(); 
      } 
    } 
    krsort ($p); 
    $r['fname'] = $res[0]; 
    $r['path'] = ($p)?"/".implode ("/",$p):""; 
    $r['type'] = $this->_getType($r['fname']); 
    return $r; 
  } 
    
  /** 
   * Small wrapper for mime_content_type, very simple 
   * 
   * @var string thing to be typed 
   * @return string mime-type 
   */ 
  function _getType ($path) {
    if (is_dir($path)) return "httpd/unix-directory"; 
    if (function_exists("mime_content_type")) 
      return mime_content_type ($path); 
    else { //если функции нет - пытаемся ее сэмулировать 
      $d = pathinfo($path); 
      switch ($d['extension']) { 
        case "html" : 
        case "htm"  : return "text/html"; 
        case "php"  : 
        case "php3" : 
        case "phtml": 
        case "phtm" : return "application/x-httpd-php"; 
        default     : return "text/plain"; 
      } 
    } 
  } 
} 

if (!function_exists("apache_lookup_uri") && !defined("Apache_LookupUri_wrapper")) { 
  define("Apache_LookupUri_wrapper", true); 
  eval('function apache_lookup_uri($uri) { return new Apache_LookupUri($uri); }');
}
?>