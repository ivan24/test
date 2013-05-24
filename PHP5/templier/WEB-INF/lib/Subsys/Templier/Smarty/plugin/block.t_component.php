<?php
require_once dirname(__FILE__)."/block.t_local.php";

function smarty_block_t_component($params, $content, &$smarty, &$repeat) {
	$t =& $smarty->Subsys_Templier;
	$name   = isset($params['name'])? $params['name'] : null;  unset($params['name']);
	$src    = isset($params['src'])?  $params['src']  : null;  unset($params['name']);
	if (!$src) {
		$smarty->trigger_error("croak[2]: t_component: missing 'src' attribute");
		return $repeat = false;
	}

	if ($content === null) {
		// Run the component.
		$result = $t->runComponent($src, $params);
		if ($result === false) {
			return $repeat = false;
		}
		if ($name || !is_array($result)) $result = array($name=>$result);
		// Save local vars.
		smarty_block_t_local(
			array("vars" => join(" ", array_keys($result))),
			$content, &$smarty
		);
		// Set variables.
		$smarty->assign($result);
	} else {
		// Restore variables.
		$content = smarty_block_t_local(array(), $content, &$smarty);
	}

	return $content;	
}
?>