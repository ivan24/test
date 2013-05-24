<?php ## Формирует меню текущего раздела.
require_once "Templier/Menu.php";
include_once "Cache/Validity/Timestamp.php";

class Templier_Menu_Cached extends Templier_Menu
{
    function main($params, &$templier)
    {
        // Generate data.
        $data = parent::main($params, $templier);

        // Create validity.
        $validity = new Cache_Validity_Timestamp();
        $validity->add($templier->requestContext->fname);
        foreach ($data['elements'] as $e) {
            $validity->add($e['context']['fname']);
        }
        $this->setValidity($validity);

        // Save cache and return data.
        return $data;
    }
}
?>