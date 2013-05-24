<?php ## Префильтр для удаления пробелов перед </td>.
function smarty_prefilter_a_delsptd($source, &$smarty) {
  $source = preg_replace("{\s+(?=</td>)}si", "", $source);
  return $source;
}
?>