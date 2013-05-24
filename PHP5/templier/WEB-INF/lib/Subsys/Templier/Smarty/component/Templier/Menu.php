<?php ## Формирует меню текущего раздела.
require_once "File/Path.php";

class Templier_Menu extends Subsys_Templier_Component
{
    var $LINES_TO_READ = 6;
    var $mask = "*.htm*";
    var $title = "title"; // lower case!!!
    var $order = "order";
    var $uri = null;
    var $templier = null;

    function main($params, &$templier)
    {
        // Fetch arguments.
        $this->templier =& $templier;
        if (isset($params['mask']))  $this->mask  = $params['mask'];
        if (isset($params['title'])) $this->title = strtolower($params['title']);
        if (isset($params['order'])) $this->order = strtolower($params['order']);
        if (isset($params['uri']))   $this->uri   = $params['uri'];

        // Iterate throught the files.
        $parent =& $templier->requestContext->getParent();
        if ($this->uri!==null) $parent =& $parent->getRelative($this->uri);
        $data = array();
        foreach ($parent->getChildren() as $child) {
            $file = $this->_parseFile($child);
            if ($file) $data[] = $file;
        }

        // Sort using order info.
        usort($data, array(&$this, '_sortCallback'));
        return array(
            "root"     => $parent->isRoot(),
            "elements" => $data,
        );
    }

    # Parse file into blocks.
    function _parseFile($context)
    {
        if (!$context->isValid()) return;
        $fname = $context->fname;
        $blocks = array();
        $f = @fopen($fname, "rb");
        if (!$f) return;
        for ($i=0; $i<$this->LINES_TO_READ && !feof($f); $i++) {
            $st = trim(fgets($f, 1024));
            if (!preg_match('/^##(\S+)\s*=\s*(.*)/s', $st, $p)) continue;
            $block = new Subsys_Templier_Block();
            $block->context =& $context;
            $block->name = $p[1];
            $block->value = $p[2];
            $block->value = preg_replace('/^(["\'])(.*)\1$/s', '$2', $block->value);
            $blocks[strtolower($block->name)] = $block;
        }
        if (!isset($blocks[$this->title])) return;
        $bOrd = isset($blocks[$this->order])? $blocks[$this->order] : null;
        if ($bOrd && $bOrd->value === '') return;
        $result = array(
            'context' => $context->getDump(),
            'title'   => $blocks[$this->title]->value,
            'order'   => $bOrd? $bOrd->value : '',
        );
        return $result;
    }

    function _sortCallback($a, $b)
    {
        list ($aT, $bT) = array($a['title'], $b['title']);
        list ($aO, $bO) = array($a['order'], $b['order']);
        list ($aD, $bD) = array($a['context']['isdir'], $b['context']['isdir']);
        if ($aO !== null && $bO !== null) return strnatcmp($aO, $bO);
        if ($aD && !$bD) return -1;
        if (!$aD && $bD) return 1;
        return strcasecmp($aT, $bT);
    }
}
?>