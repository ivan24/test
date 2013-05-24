<?php
# Replaces {{name}} to {t_ins block="name"}.
function smarty_prefilter_a_ins($source, &$smarty) {
	$tag = "t_ins";
	$l = $smarty->left_delimiter;
	$r = $smarty->right_delimiter;
	$ll = "{$l}{$l}";
	$rr = "{$r}{$r}";
	$source = preg_replace("/{$ll}(\w+)(.*?){$rr}/s", "{$l}$tag block=\"$1\" $2{$r}", $source);
	return $source;
}
?>