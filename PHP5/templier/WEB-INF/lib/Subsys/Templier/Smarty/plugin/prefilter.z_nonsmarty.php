<?php
# Quotes each "{" with spaces after it.
function smarty_prefilter_z_nonsmarty($source, &$smarty) {
	$l = $smarty->left_delimiter;
	$r = $smarty->right_delimiter;	
	$source = preg_replace('/'.preg_quote($l, '/').'(?=[\s{(\[])/s', "{$l}ldelim{$r}", $source);
	return $source;
}
?>