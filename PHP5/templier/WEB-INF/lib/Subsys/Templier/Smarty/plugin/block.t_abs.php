<?php
function smarty_block_t_abs($params, $content, &$smarty) {
	$t =& $smarty->Subsys_Templier;
	if ($content === null) return;
    $context = $t->context->getRelative(trim($content));
    if (!$context) return;
    $uri = $context->uri;
    #$uri = preg_replace('{(.)/+$}s', '$1', $context->uri);
    if (isset($params['out'])) {
        if ($uri{0} == '/') $uri = "http://{$_SERVER['HTTP_HOST']}$uri";
    }
	return $uri;
}
?>