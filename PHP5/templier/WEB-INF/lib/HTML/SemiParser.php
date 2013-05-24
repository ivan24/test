<?php
/**
 * vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker:
 */
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Original Author <author@example.com>                        |
// |          Your Name <you@example.com>                                 |
// +----------------------------------------------------------------------+
// $Id: standards.xml,v 1.24 2004/05/31 04:25:36 danielc Exp $
/**
 * HTML_SemiParser
 * 
 * @package 
 * @author Administrator 
 * @copyright Copyright (c) 2004
 * @version $Id$
 * @access public 
 */
class HTML_SemiParser
{
    var $VERSION = "1.11";
    
    // Handled sp_tags & containers
    var $sp_tags = array(); // array(tagName => list( h1, h2, ...), ...)
    var $sp_cons = array();
    var $sp_res = array();
    var $sp_preTag = "tag_";
    var $sp_preCon = "container_";
    var $sp_preRe = "re_";
    var $sp_trans = array();
    var $sp_reTagIn = '(?:(?xs) (?: [^>"\']+ | " (?:[^"\\\\]+|\\\\"|\\\\)* " | \' (?:[^\'\\\\]+|\\\\\'|\\\\)* \' )* )'; 
    // For tag searcher - local temp variables.
    var $sp_replaceHash; // unique hash to replace all the tags
    var $sp_foundTags; // all tags found
    var $sp_curTagNum; // number of current processing tag
    var $sp_curReplaceType; // type: sp_tags or sp_cons     
    /**
     * HTML_SemiParser constructor.
     */
    function HTML_SemiParser()
    {
        $this->addObject($this);
        $this->trans = array_flip(get_html_translation_table(HTML_SPECIALCHARS)); 
        // generate unique hash.
        list ($m, $t) = explode(" ", microtime());
        $uniq = uniqid("");
        $this->sp_replaceHash = str_replace(
            chr(0), chr(1), // chr(0) in preg_* does NOT work!!!
            chr(0) . $uniq
            );
    } 

    /**
     * Add new tag handler for future processing.
     * 
     * Handler is a callback which is will be for each tag found in the parsed document.
     * This callback could be used to replace tag. Here is the prototype:
     * 
     * mixed handler(array $attributes)
     * 
     * Callback get 1 parameter - parset tag attribute array.
     * The following types instead of "mixed" is supported:
     * 
     * - bool or NULL
     *   If handler returns FALSE or NULL, source tag is not modified.
     * - string
     *                      Returning value is used t replace original tag.
     * - array
     *                      Returning value is treated as associative array of tag attributes. Array also
     *                      contains two special elements: 
     *                      - "_tagName":  name of tag;
     *                      - "_text":     string representation of tag body (for containers only, see below).
     *                      String representation of tag will be reconstructed automatically by that array.
     * 
     * @param string $tagName Name of tag to handle. For example, "a", "img" etc.
     * @param callback $handler Callback which will be called on for each found tag.
     * @return void 
     */
    function addTag($tagName, $handler)
    {
        $tagName = strtolower($tagName);
        if (!isSet($this->sp_tags[$tagName])) $this->sp_tags[$tagName] = array();
        $this->sp_tags[$tagName][] = &$handler; 
        // echo "Tag added: $tagName<br>\n";
    } 

    /**
     * Add the container handler.
     * 
     * Containers are processed just like simple tags (see addTag()), but they also have
     * bodies saved in "_text" attribute.
     * 
     * @param string $tagName 
     * @param callback $handler 
     * @return void 
     */
    function addContainer($tagName, $handler)
    {
        $tagName = strtolower($tagName);
        if (!isSet($this->sp_cons[$tagName])) $this->sp_cons[$tagName] = array();
        $this->sp_cons[$tagName][] = &$handler; 
        // echo "Container added: $tagName\n";
    } 
    // Adds regular expression replacer.
    // Uses callback with obe parameter: RE matched pockets.
    function addReplace($re, $handler)
    {
        if (!isSet($this->sp_res[$re])) $this->sp_res[$re] = array();
        $this->sp_res[$re][] = &$handler;
    } 
    // Adds all the callback methods in $obj.
    function addObject(&$obj)
    { 
        // Searches for all the derieved handlers.
        foreach (get_class_methods($obj) as $m)
        {
            if (strpos($m, $this->sp_preTag) === 0)
            {
                $this->addTag(substr($m, strlen($this->sp_preTag)), array(&$obj, $m));
            } 
            if (strpos($m, $this->sp_preCon) === 0)
                $this->addContainer(substr($m, strlen($this->sp_preCon)), array(&$obj, $m));
            if (strpos($m, $this->sp_preRe) === 0)
            {
                $meth = substr($m, strlen($this->sp_preRe));
                $re = call_user_func(array(&$obj, $m));
                if ($re !== false && $re !== null)
                    $this->addReplace($re, array(&$obj, $meth));
            } 
        } 
    } 
    // Function to handle HTML buffer.
    function process($buf)
    { 
        // Replace custom REs.
        if ($this->sp_res)
        {
            foreach ($this->sp_res as $re => $handlers)
            {
                foreach ($handlers as $h)
                {
                    $buf = preg_replace_callback($re, $h, $buf);
                } 
            } 
        } 
        // Replace tags.
        $reTagNames = join("|", array_keys($this->sp_tags));
        $reConNames = join("|", array_keys($this->sp_cons));
        $reTagIn = $this->sp_reTagIn;
        $infos = array();
        if ($this->sp_tags) $infos["sp_tags"] = "/<($reTagNames) ($reTagIn) \\/?>/isx";
        if ($this->sp_cons) $infos["sp_cons"] = "/<($reConNames) ($reTagIn) > (.*?) (?: <\\/ \\1 \\s* > | (?= < \\1 | \$ ) ) /isx";
        foreach ($infos as $src => $re)
        {
            $this->sp_curReplaceType = $src;
            $this->sp_foundTags = array(); 
            // Replace tags (or container) to hash value.
            $buf = preg_replace_callback($re,
                array(&$this, "_callbackTagReplacerAndSaver"),
                $buf
                ); 
            // echo htmlspecialchars("$src $re ".count($this->sp_foundTags))."<br>\n";
            // Precache all the found tags (if needed).
            $this->_precacheTags(); 
            // Replace hashes to computed values back.
            $this->sp_curTagNum = 0;

            $buf = preg_replace_callback('/' . preg_quote($this->sp_replaceHash) . '/s',
                array(&$this, "_callbackHashReplacerAndSaver"),
                $buf
                ); 
            // Clean unused memory.
            unset($this->sp_foundTags);
        } 

        return $buf;
    } 
    // Uses client precache functions.
    function _precacheTags()
    {
    } 
    // Callback to replace some RE to hash value.
    // Always returns the same $sp_replaceHash.
    // Saves found matches to $sp_foundTags[].
    function _callbackTagReplacerAndSaver($m)
    {
        $this->sp_foundTags[] = &$m;
        return $this->sp_replaceHash;
    } 
    // Callback to replace hash value back to processed tag.
    // Uses (and increments) $sp_curTagNum as index of $sp_foundTags.
    // Returns the text representation of resolved tag.
    function _callbackHashReplacerAndSaver($m)
    {
        $n = $this->sp_curTagNum++;
        $tagMatches = $this->sp_foundTags[$n];
        return $this->_replaceTagOrCont($tagMatches);
    } 
    // Recreates the tag by its data.
    // If $attr[_text] is present, makes container.
    function makeTag($attr)
    { 
        // Join & return tag.
        $s = "";
        foreach($attr as $k => $v)
        {
            if ($k == "_text" || $k == "_tagName") continue;
            $s .= " $k=\"" . htmlspecialchars($v) . "\"";
        } 
        if (!@$attr['_tagName']) $attr['_tagName'] = "???";
        $tag = "<" . $attr['_tagName'] . $s . ">";
        if (isSet($attr['_text'])) $tag .= $attr['_text'] . "</" . $attr['_tagName'] . ">";
        return $tag;
    } 
    // RE callback to replace tag content.
    function _replaceTagOrCont($m)
    {
        $this->parseAttrib($m[2], $attr);
        $attr['_tagName'] = $m[1];
        $tagName = strtolower($attr['_tagName']); 
        // echo htmlspecialchars($m[0])."<br>\n";
        // Processing tag or container?..
        if (isSet($m[3]))
        {
            $attr['_text'] = $m[3];
            $src = &$this->sp_cons[$tagName];
        } 
        else
        {
            $src = &$this->sp_tags[$tagName];
        } 
        // Use all handlers right-to-left.
        $changed = false;
        for ($i = count($src)-1; $i >= 0; $i--)
        {
            $h = &$src[$i];
            $result = false;
            if (is_array($h))
            { 
                // Handler is $obj->method.
                $obj = &$h[0];
                $meth = $h[1];
                $result = $obj->$meth(&$attr, $m[0]);
            } 
            else
            { 
                // Function reference.
                $result = $h(&$attr, $m[0]);
            } 
            // If returned false, tag is not changed.
            if ($result !== false && $result !== null)
            { 
                // If the string is returned, stop ptocessing now.
                if (!is_array($result)) return $result; 
                // Alse continue.
                $attr = $result;
                $changed = true;
            } 
        } 
        // If the tag is not changed, return original string.
        return $changed? $this->makeTag($attr) : $m[0];
    } 
    // Parses the attribute string: "a1=v1 a2=v2 ..." of tag.
    function parseAttrib($body, &$attr)
    { 
        // echo "[$body]<br>\n";
        $preg = "/(\\w+) \\s* ( = \\s* (?: (\"[^\"]*\" | '[^']*' | \\S*) ) )?/sx";
        preg_match_all($preg, $body, $regs); 
        // print_r($regs);
        $names = $regs[1];
        $checks = $regs[2];
        $values = $regs[3];
        $attr = array();
        for ($i = 0, $c = count($names); $i < $c; $i++)
        {
            $name = strtolower($names[$i]);
            if (!@$checks[$i])
            {
                $value = $name;
            } 
            else
            {
                $value = $values[$i];
                if ($value[0] == '"' || $value[0] == "'")
                {
                    $value = substr($value, 1, -1);
                } 
            } 
            if (strpos($value, '&') !== false)
                $value = strtr($value, $this->trans);
            $attr[$name] = $value;
        } 
    } 
} 

?>