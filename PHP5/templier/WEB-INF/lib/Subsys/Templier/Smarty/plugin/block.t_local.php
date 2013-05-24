<?php
function smarty_block_t_local($params, $content, &$smarty) {
	$t =& $smarty->Subsys_Templier;
	$vars = isset($params['vars']) ? preg_split('/[\s,;]+/s', trim($params['vars'])) : null;
	if ($content === null) {
		$smarty->insvarStack[] = array(
			$vars,
			$smarty->get_template_vars()
		);
		return null;
	} else {
		list ($vars, $save) = array_pop($smarty->insvarStack);
		if ($vars) {
			// Save only some variables.
			foreach ($vars as $k) {
				if (isset($save[$k])) $smarty->assign($k, $save[$k]);
				else $smarty->clear_assign($k);
			}
		} else {
			// Save all variables.
			$smarty->clear_all_assign();
			$smarty->assign($save);
		}
		return $content;
	}
}
?>