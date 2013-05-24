<?php
//
// Works fine with both display_error and log_error.
// Used to create and then dump stacktraces while debugging.
//
class Debug_BacktraceDumper {
	var $VERSION = "0.30";

	var $aliases = array();
	var $trace = array();

	// Create new tracer.
	function Debug_BacktraceDumper() {
		$this->addAlias(realpath($_SERVER['DOCUMENT_ROOT']), "~");
		$this->addAlias("", array(&$this, '__callbackGetSmartyTplName'), true);
	}
	
	// Fills theinformation.
	function prepare($errno, $errstr, $errfile, $errline, $stack=0) {
	 	if (is_numeric($stack)) {
		 	$trace = debug_backtrace();
			$stack = array_splice($trace, $stack+1);
 		}

		// Prepare error context.
		$types = array(
			"E_ERROR", "E_WARNING", "E_PARSE", "E_NOTICE", "E_CORE_ERROR",
			"E_CORE_WARNING", "E_COMPILE_ERROR", "E_COMPILE_WARNING", 
			"E_USER_ERROR", "E_USER_WARNING", "E_USER_NOTICE", "E_STRICT",
		);
		// Textual error type.
		$type = array();
		foreach ($types as $t) {
			$e = defined($t)? constant($t) : 0;
			if ($errno & $e) $type[] = $t;
		}
		$type = join(",", $type);
		// Prepare stack.
		array_unshift($stack, array(
			"file" => $errfile,
			"line" => $errline,
		));
		foreach ($stack as $i=>$s) {
			$stack[$i]['name'] = $this->_getDebugFileName(isset($s['file'])? $s['file'] : __FILE__);
		}
		// In croak mode we need to skip some stack elements.
		$first = $stack[0];
		if (preg_match('/(\s+|^) croak \s* ([([] (\d+) [)\]])? \s*:/isx', $errstr, $p) && @$stack[1]) {
			$errstr = str_replace($p[0], '', $errstr);
			$num = isset($p[3])? $p[3] : 1;
			$first = $stack[$num];
		}
		// Save full error info.
		$this->trace = array(
			"errtype" => $type,
			"errno"   => $errno,
			"errstr"  => $errstr,
			"stack"   => $stack,
		) + $first;
	}

	// Adds path aliaser.
	function addAlias($root, $repl, $isCallback=false) {
		$this->aliases[] = array(
			"root" => str_replace('\\', '/', $root),
			"repl" => $repl,
			"isCallback" => $isCallback
		);
	}

	// Returns associated stacktrace.
	function getTrace() {
		return $this->trace;
	}

	// Sows the message (and, maybe, adds it to the log).
	function show($contentType="html") {
		if (ini_get("display_errors"))
			echo $this->format(dirname(__FILE__)."/BacktraceDumper/$contentType.php");
		if (ini_get("log_errors")) {
			error_log($this->format(dirname(__FILE__)."/BacktraceDumper/text.php"));
		}
	}

	// Returns formatted stacktrace.
	function format($tplFile=null) {
		$error = $this->getTrace();
		ob_start();
		if ($tplFile !== null) {
			include $tplFile;
		} else {
			print_r($error);
		}
		$text = ob_get_contents(); ob_end_clean();
		$text = preg_replace('/<!--.*?-->/s', "", $text);
		$text = preg_replace('/\t/m', '', $text);
		$text = preg_replace('/\s*[\r\n]+/s', ' ', $text);
		$text = preg_replace('/\\\\n/s', "\n", $text);
		return $text;
	}

	// Sets current PHP error handler to default.
	// static
	function set_error_handler() {
		set_error_handler(array("Debug_BacktraceDumper", "__errorHandler"));	
	}


	//
	// PRIVATE
	//

	// Error handler.
	function __errorHandler($errno, $errstr, $errfile, $errline) {
		if (!($errno & error_reporting())) return;
		$trace = new Debug_BacktraceDumper();
		$stack = array_splice(debug_backtrace(), 2); // BUG! Need separate variable $stack!
		$trace->prepare($errno, $errstr, $errfile, $errline, $stack);
		$trace->show();
	}

	// Tries to shrink filename.
	function _getDebugFileName($fname) {
		$orig = false;
		for ($i=0; $orig!=$fname && $i<10; $i++) {
			$orig = $fname;
			foreach ($this->aliases as $a) {
				$fname = str_replace('\\', '/', $fname);
				$rootRe = $a['root']? preg_quote($a['root'], '/') : "";
				if ($a['isCallback']) {
					$fname = preg_replace_callback("/^($rootRe).*/s", $a['repl'], $fname);
				} else {
					$fname = preg_replace("/^($rootRe)/si", $a['repl'], $fname);
				}
			}
		}
		return $fname;
	}

	// Callback function for preg_replace_callback().
	// Fetches real file name from compiled template.	
	function __callbackGetSmartyTplName($p) {
		$fname = $p[0];
		if (!file_exists($fname)) return $fname;
		$f = fopen($fname, "rb");
		for ($lines=array(), $i=0; $i<2; $i++) $lines[] = fgets($f, 1024);
		fclose($f);
		$lines = join('', $lines);
		if (!preg_match('/\bcompiled\s+from\s+(\S+)/s', $lines, $pock)) 
			return $fname;
		return $pock[1];
	}
}

//
// Example:
//   <?php
//   require_once "WEB-INF/config.php";
//   require_once "PHP/Debug/BacktraceDumper.php";
//   Debug_BacktraceDumper::set_error_handler();
//   function F() { echo $nonExistent; }
//   echo "Hello, world!";
//   F();
//   echo "Hi there!";
//
?>