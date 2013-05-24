<?php
# Insert block body.
function smarty_function_t_ins($params, &$smarty) {
	$t =& $smarty->Subsys_Templier;

	$block   = isset($params['block'])?   $params['block'] : null;
	$glue    = isset($params['glue'])?    $params['glue'] : null;
	$lskip   = isset($params['lskip'])?   $params['lskip'] : 0;
	$rskip   = isset($params['rskip'])?   $params['rskip'] : 0;
	$reverse = isset($params['reverse'])? $params['reverse'] : false;
	$default = isset($params['default'])? $params['default'] : null;

	if ($block === null) {
		$smarty->trigger_error("croak[2]: t_ins: missing 'block' parameter");
		return;
	}

	if ($glue !== null) {
		$blocks = $t->findBlocks($block);
		if ($blocks !== null) {
			$num = count($blocks);
			$blocks = array_splice($blocks, $lskip, $num - $lskip - $rskip);
			if ($reverse && $reverse != "no" && $reverse != "false")
				$blocks = array_reverse($blocks);
			$result = array();
			foreach ($blocks as $b) {
				$result[] = $b->value;
			}
			$result = join($glue, $result);
		} else {
			$result = null;
		}
	} else {
		$result = $t->getBlockBody($block);
	}
	if ($result === null) $result = $default;
	if ($result === null) {
		$smarty->trigger_error("croak[2]: t_ins: no such block '$block' nor 'default' attribute specified");
		return;
	}
	return $result;
}
?>