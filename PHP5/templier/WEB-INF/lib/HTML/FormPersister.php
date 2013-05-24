<?php
/*
 * Modify HTML-form adding value="..." fields according to $_REQUEST.
 * A lot of other functions (e.g., select, textarea, img also supported).
 * (C) Dmitry Koteroff, 2004.
 */

require_once "HTML/SemiParser.php";

define("HTML_FormPersister_flip_pre", "@");
define("HTML_FormPersister_flip_suf", "");

class HTML_FormPersister extends HTML_SemiParser {
	var $VERSION = "1.11";
	
	// Variable to count []-s.
	var $squareCount = array();

	// Creates new FormPersister instance.
	function HTML_FormPersister() {
		$this->HTML_SemiParser();
	}

	// Converts name attribute for flip fields.
	// Cleans some non-existed attributes (like "default").
	function makeTag($attr) {
		// Prepare enhanced names.
		if (isSet($attr['name']) && @$attr['flip']) {
			$name = str_replace("[]","",$attr['name'])."[]";
			$attr['name'] = preg_replace("/^([^[]+)/", HTML_FormPersister_flip_pre.'$1'.HTML_FormPersister_flip_suf, $name);
		}
		unSet($attr['default']);
		unSet($attr['flip']);
		return HTML_SemiParser::makeTag($attr);
	}

	// Virtual function.
	function process($st) {
		$this->squareCount = array();
		return HTML_SemiParser::process($st);
	}

	function getimagesize_byUri($src) {
		$fname = false;
		// When mod_rewrite is active, we shoild NOT lookupe RELATIVE 
		// urls (apache bug?). Then always lookup absolute urls.
		if ($src && $src[0]!='/') {
			$dir = dirname($_SERVER['SCRIPT_NAME']);
			if (!$dir || $dir == "/" || $dir == "\\") $dir = "";
			$src = "$dir/$src";
		}
		// Use apache stuff (if available).
		if (function_exists("apache_lookup_uri")) {
			$info = apache_lookup_uri($src);
			$src = @$info->path_info? $info->path_info : (@$info->uri? $info->uri : $src);
			$fname = $info->filename;
		} else {
			// Primitive URL resolving.
			if ($src[0] == '/') $fname = $_SERVER["DOCUMENT_ROOT"].$src;
			else $fname = dirname($_SERVER["SCRIPT_FILENAME"])."/".$src;
		}
		if ($fname===false) return;

		static $cache = array();
		$cacheId = $fname;
		if (isset($cache[$cacheId])) return $cache[$cacheId];
		
		$isz = @getimagesize($fname);
		if(!@$isz) return;
		$isz['uri'] = $src;
		$isz['fname'] = $fname;
		$isz['width'] = $isz[0];
		$isz['height'] = $isz[1];
		return $cache[$cacheId]=$isz;
	}

	// <IMG> tag processor.
	function tag_img($attr) {
		// No need to set width-height.
		if (isSet($attr['width']) || isSet($attr['height']) || !isSet($attr['src'])) return;
		// Determime picture parameters.
		$isz = @HTML_FormPersister::getimagesize_byUri($attr['src']);
		if(!@$isz) return;
		$attr['width'] = $isz[0];
		$attr['height'] = $isz[1];
		return $attr;
	}

	// <FORM> tag (default action attribute).
	function tag_form($attr) {
		if(isSet($attr['action'])) return;
		$attr['action'] = $_SERVER["SCRIPT_NAME"];
		return $attr;
	}

	// <INPUT> tag processor.
	function tag_input($attr) {
		static $uid = 0;
		switch ($type = @strtolower($attr['type'])) {
			case "text": case "password": case "hidden":
				if (!isSet($attr['name'])) return;
				unSet($attr["flip"]); // cannot use flip mode!
				if (!isSet($attr['value']))
					$attr['value'] = $this->getCurValue($attr);
				break;
			case "radio":
				if (!isSet($attr['name'])) return;
				if (isSet($attr['checked']) || !isSet($attr['value'])) return;
				unSet($attr["flip"]);
				if ($attr['value'] == $this->getCurValue($attr)) $attr['checked'] = "checked";
				else unSet($attr['checked']);
				break;
			case "checkbox":
				if (!isSet($attr['name'])) return;
				if (isSet($attr['checked'])) return;
				if ($this->getCurValue($attr, true)) $attr['checked'] = "checked";
				break;
			case "submit":
				if (isSet($attr['confirm'])) {
					$attr['onclick'] = 'return confirm("'.$attr['confirm'].'")';
					unSet($attr['confirm']);
				}
				break;
			default:
				return;
		}
		// Handle label pseudo-attribute. Button is placed RIGHTER
		// than the text if label text ends with "^". Example:
		// <input type=checkbox label="hello">   ==>  [x]hello
		// <input type=checkbox label="hello^">  ==>  hello[x]
		if (isSet($attr['label'])) {
			$text = $attr['label'];
			if (!isSet($attr['id'])) $attr['id'] = 'FPlab'.($uid++);
			if ($text[strlen($text)-1]=='^') { $right=1; $text=substr($text,0,-1); }
			unSet($attr['label']);
			$attr = array(
				"_tagName" => "label",
				"_text"    => @$right? $text.$this->makeTag($attr) : $this->makeTag($attr).$text,
				"for"      => $attr['id'],
			);
		}
		return $attr;
	}

	// <TEXTAREA> tag processor.
	function container_textarea($attr) {
		unSet($attr["flip"]);
		if (trim($attr['_text'])=="") 
			$attr['_text'] = htmlspecialchars($this->getCurValue($attr));
		return $attr;
	}

	// <SELECT> tag processor.
	function container_select($attr) {
		// Non-multiple lists cannot be flipped.
		// Multiple lists MUST contain [] in the name.
		if(!isSet($attr["multiple"])) unSet($attr["flip"]);
		elseif(strpos($attr['name'],"[]")===false) $attr['name'].="[]";

		$curVal = $this->getCurValue($attr);
		$body = "\n";
		$parts = preg_split("/<option\s*({$this->sp_reTagIn})>/si", $attr['_text'], -1, PREG_SPLIT_DELIM_CAPTURE);
		#echo "/<option\s*({$this->sp_reTagIn})>/si";
		#print_r($parts);
		for ($i=1, $n=count($parts); $i<$n; $i+=2) {
			$opt = array();
			$this->parseAttrib($parts[$i], $opt);
			$opt['_text'] = preg_replace('{</[^>]*option[^>]*>.*}si', '', $parts[$i+1]);
			$opt['_tagName'] = "option";
			// Option without value: spaces are shrinked (experimented on IE).
			if (!isset($opt['value'])) {
				$value = trim($opt['_text']);
				$value = preg_replace('/\s\s+/', ' ', $value);
                if (strpos($value, '&') !== false)
                	$value = strtr($value, $this->trans);
			} else {
				$value = $opt['value'];
			}
			if (isSet($attr['multiple'])) {
				// Inherit some <select> attributes.
				if ($this->getCurValue($opt + $attr, true)) // merge
					$opt['selected'] = "selected";
			} else {
				if ($curVal == $value)
					$opt['selected'] = "selected";
			}
			$opt['_text'] = rtrim($opt['_text']);
			$body .= $this->makeTag($opt)."\n";
		}
		$attr['_text'] = $body;
		return $attr;
	}


	//**
	//** Value extractors.
	//**

	// Returns the current value of specified tag.
	function getCurValue($attr, $isBoolean=false) {
		$name = $attr['name'];

		// Handle many fields like <input type=TEXT name=txt[]>.
		// We need to READ it sequentially.
		if (($p=strpos($name, "[]")) !== false) {
			if(!$isBoolean) {
				if(!@$this->squareCount[$name]) $this->squareCount[$name]=0;
				$name = substr($name,0,$p)."[".$this->squareCount[$name]."]".substr($name,$p+2);
				$this->squareCount[$attr['name']]++;
			} else {
				$name = substr($name,0,$p).substr($name,$p+2);
			}
		}
		
		// Search for value in ALL arrays,
		// EXCEPT $_REQUEST, because it also holds Cookies!
		$fromForm = true;
		if     (($v=$this->_deepFetch($_POST,    $name)) !== false) $value = $v;
		elseif (($v=$this->_deepFetch($_GET,     $name)) !== false) $value = $v;
		elseif (isSet($attr['default'])) {
			$value = $attr['default'];
			if ($isBoolean) return $value!=="";
			$fromForm = false;
		} else $value = '';
		if ($fromForm) {
			// Remove slashes on stupid magic_quotes_gpc mode.
			if (ini_get('magic_quotes_gpc')) $value = stripslashes($value);
		}

		// For arrays - transfer data into the VALUES (for flip-fields).
		// If we use <input type=checkbox name=c[] value=123>,
		// data is ALREADY in values of $c. But if we use
		// <input type=checkbox name=c value=123 flip>,
		// data is in KEYS of $c: array(123=>1, ...).
		if (is_array($value) && isSet($attr['flip'])) {
			$old = $value; $value = array();
			// Strip ONLY empty keys (for future purposes).
			foreach ($old as $k=>$v) if ($v!=="") $value[] = $k;
		}

		// Array-like field?
		if (strpos($attr['name'],"[]") === strlen($name) || isSet($attr['flip'])) {
			// For array fields it is possible to enumerate all the
			// values in SCALAR using ";".
			if (!is_array($value)) $value = explode(";",$value);
			// If present, returns OK.
			return in_array($attr['value'], $value);
		} else {
			// This is not an array field. Return it now.
			return @strval($value);
		}
	}

	// Returns an element of $arr array using key $name.
	// $name can be in form of "zzz[aaa][bbb]".
	// Returns false if $name is not found.
	function _deepFetch(&$arr, $name) { // static
		// Fast fetch.
		if (strpos($name,"[") === false) {
			return isSet($arr[$name])? $arr[$name] : false;
		}
		// Else search into deep.
		$parts = $this->_splitMultiArray($name);
		foreach ($parts as $k) {
			if (!is_array($arr)) return $arr;
			if (!isSet($arr[$k])) return false;
			$arr =& $arr[$k];
		}
		return $arr;
	}

	// Highly internal function. Must be re-written if some new 
	// version of would support syntax like "zzz['aaa']['b\'b']" etc.
	// For "zzz[aaa][bbb]" returns array(zzz, aaa, bbb).
	function _splitMultiArray($name) { // static
		if (is_array($name)) return $name;
		preg_match_all("/ ( ^[^[]+ | \\[ .*? \\] ) (?= \\[ | \$) /xs", $name, $regs);
		$arr = array();
		foreach ($regs[0] as $s) {
			if ($s[0] == '[') $arr[] = substr($s, 1, -1); 
			else $arr[] = $s;
		}
		return $arr;
	}


	//**
	//** PHP form-data correction.
	//**

	// Called on first module load. Processes all the 
	// flip fields in $GLOBALS (and some deeper).
	function _processFlip(&$G, $depth=1) { // static
		$lLen = strlen(HTML_FormPersister_flip_pre);
		$rLen = strlen(HTML_FormPersister_flip_suf);
		foreach ($G as $k=>$arr) {
			if ($k == "GLOBALS" && $depth==1) continue;
			if (
				substr($k,0,$lLen) == HTML_FormPersister_flip_pre &&
				substr($k,-$lLen) != HTML_FormPersister_flip_suf
			) {
				// Find deepest array.
				unSet($G[$k]);
				$G[substr($k,$lLen,strlen($k)-$lLen-$rLen)] = HTML_FormPersister::_processFlipField($arr);
			} else {
				if ($depth>2) continue; // too deep
				if (is_array($arr)) 
					HTML_FormPersister::_processFlip(&$G[$k], $depth+1);
			}
		}
	}

	// Processes ONE array $top, considering it as some[a][b][]-style field.
	// Returns the new associative array. Example:
	//   QUERY_STRING = some[a][b][]=10&some[a][b][]=20
	//   Result: array(a=>array(b=>array(10=>1, 20=>1)))
	// Another example:
	//   QUERY_STRING = some[]=10&some[]=20
	//   Result: array(10=>1, 20=>1)
	function _processFlipField($top) { // static
		if (!is_array($top)) return $top;
		Reset($top);
		if (!is_array(current($top))) {
			$new = array();
			foreach($top as $v) $new[$v] = 1;
			return $new;
		} else {
			foreach($top as $k=>$v)
				$top[$k] = HTML_FormPersister::_processFlipField($v);
			return $top;
		}
	}
}

// Process all "flip" fields.
HTML_FormPersister::_processFlip(&$GLOBALS);

// Handler for ob_start.
function ob_formpersisterhandler($st) {
	$fp =& new HTML_FormPersister();
	$r = $fp->process($st);
#	$f = fopen("/r","w");
#	fwrite($f,$r);
#	fclose($f);
	return $r;

}
?>