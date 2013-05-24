<?php
function smarty_block_t_block($params, $content, &$smarty) {
	$t =& $smarty->Subsys_Templier;

	if (!isset($params['name'])) {
		$smarty->trigger_error("croak[2]: t_block: missing 'name' attribute");	
		return;
	}
	
	if (isset($params['value'])) {
		$t->addBlock($params['name'], $params['value'], @$params['raw']);
	} else {
		if ($content !== null) {
			$t->addBlock($params['name'], $content, isset($params['raw']));
		}
	}
}
?>