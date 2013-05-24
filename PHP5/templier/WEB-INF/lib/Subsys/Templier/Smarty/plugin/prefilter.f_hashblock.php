<?php
define("SMARTY_HASH_BLOCK", "##");

# Replaces ##Block and ##Block=value syntax with {t_block}...{/t_block}.
function smarty_prefilter_f_hashblock($source, &$smarty) {
	$tag = "t_block";
	$re = "[\w@]+";
	$l = $smarty->left_delimiter;
	$r = $smarty->right_delimiter;	
	$blocks = preg_split("/^".SMARTY_HASH_BLOCK."($re.*$)/m", $source, -1, PREG_SPLIT_DELIM_CAPTURE);
	$text = $blocks[0];
	##
	## Do not strip spaces here! It breaks up line numbering.
	##
	for ($i=1; $i<count($blocks); $i+=2) {
		# $i - always position of block header.	
		$head = $blocks[$i];
		$body = $blocks[$i+1];
		if (!preg_match("/^($re+)(?:(\s*=\s*(.*)$)|\s*(.*))/s", $head, $p)) continue;
		if (isset($p[4])) $body = $p[4].$body;
		$name = $p[1];
		$raw = false;
		if ($p[2]) {
			# single-line
			$orig = $content = trim($p[3]);
			$content = preg_replace('/^(["\'])(.*)\1$/s', '$2', $content);
			if ($orig != $content) $raw = true;
		} else {
			# moulti-line
			$content = $body;
			$body = '';
		}
		$text .= "{$l}$tag name=\"$name\"".($raw?' raw="raw"':'')."{$r}$content{$l}/$tag{$r}$body";
	}
#	echo "<pre>".print_r($blocks,1)."</pre>";	exit;	
#	echo "<pre>".$text."</pre>";	exit;
	return $text;
}
?>