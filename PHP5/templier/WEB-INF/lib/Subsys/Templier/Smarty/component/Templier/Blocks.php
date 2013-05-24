<?php ## ¬озвращает массив блоков с указанным именем.

class Templier_Blocks extends Subsys_Templier_Component
{
    function main($params, &$templier) 
    {
        if (!isset($params['block'])) {
            $this->croak("Templier_Blocks: missing 'block' attribute", E_USER_ERROR);   
            return false;
        }
        $block = $params['block'];
        $blocks = $templier->findBlocks($block);
        $result = array();
        foreach ($blocks as $b) {
            $result[] = $b->getDump();
        }
        if ($result) {
        	$result[0]['isfirst'] = true;
        	$result[count($result)-1]['islast'] = true;
        }
        return $result;
    }
}
?>