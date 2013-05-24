<?php
$smarty_block_t_activator_trans = array_flip(get_html_translation_table(HTML_SPECIALCHARS)); 

function smarty_block_t_activator($params, $content, &$smarty) {
	if ($content === null) return;
	$GLOBALS['smarty_block_t_activator'] = array(
		&$smarty->Subsys_Templier,
		$params,
	);
	$text = preg_replace_callback('/
		<a \s [^>]* href \s* = \s* (?:
			"  ([^"]*  ) "  | 
			\' ([^\']* ) \' |
			   ([^\s>]*)
		)
	/sx', "smarty_block_t_activator_callback", $content);
	unset($GLOBALS['smarty_block_t_activator']);
	return $text;
}

function smarty_block_t_activator_callback($p) {
	$t      =& $GLOBALS['smarty_block_t_activator'][0];
	$params =& $GLOBALS['smarty_block_t_activator'][1];
    // Fetch parameters.
    $types = array(
        'current' => 'classcurrent',
        'active'  => 'classactive',
        'missed'  => 'classmissed',
        'anchor'  => 'classanchor',
        'outer'   => 'classouter',
    );
    foreach ($types as $k=>$v) {
	    if (isset($params[$v])) $types[$k] = $params[$v];
        else $types[$k] = $k;
    }
    // Parse URL.
	$url = $p[1]!==''? $p[1] : ($p[2]!==''? $p[2] : $p[3]);
    if (strpos($url, '&') !== false) $url = strtr($url, $GLOBALS['smarty_block_t_activator_trans']);
    // Detect class name.
    $add = '';
    if (preg_match('{^\w+://}s', $url)) {
        $add = $types['outer'];
    } else if (preg_match('{^#}s', $url)) {
        $add = $types['anchor'];
    } else {
	    $context = $t->context->getRelative(trim($url));
        if (!$context) $add = $types['missed'];
	    else if ($context->isCurrent()) $add = $types['current'];
	    else if ($context->isActive())  $add = $types['active'];
    }
	return $p[0] . ($add? ' class="'.$add.'"' : '');
}
?>