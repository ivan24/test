<?php
//**
//** Some filepath related tools.
//**

class File_Path {
	var $VERSION = "1.10";

	// Returns the absolute path.
	function absPath($name, $cur=false) {
		// Glue full name.
		if ($cur === false) $cur = getcwd();
		if (!File_Path::isAbsolute($name))
			$name = File_Path::gluePath($cur, $name);
		$orig = preg_split("{[/\\\\]}s", $name);
		$absolute = File_Path::isAbsolute($name);
		// Delete ".." and "." parts.
		$parts = array();
		foreach ($orig as $e) {
			if ($e == ".") 	continue;
			else if ($e == "..") {
				$size = sizeof($parts);
				if ($size > 1) array_pop($parts);
				else if (!$absolute) $parts = array(".");
			}
			else $parts[] = $e;
		}
		// Process root separately.
		if (!sizeof($parts)) return ".";
		if ($absolute && sizeof($parts)==1 && $parts[0] === "") return "/";
		return implode("/", $parts);
	}

	// Glues two pathes avoiding slashes duplicates.
	// Also normalizes slashes (converts to "/").
	function gluePath($dir, $fname) {
		$all = $dir."/".$fname;
		$all = preg_replace("{[\\\\//]+}s", "/", $all);
		$all = preg_replace("{/$}s", "", $all);
		return $all;
	}

	// Returns true if the path is absolute.
	function isAbsolute($path) {
		return preg_match("{^(\w:)?[/\\\\]}s", $path);
	}

	// Creates directory structure.
	function mkdirs($strPath, $mode) {
		if (file_exists($strPath) && is_dir($strPath)) return true;
		$pStrPath = dirname($strPath);
		if (!File_Path::mkdirs($pStrPath, $mode)) return false;
		return mkdir($strPath);
	}

}

?>