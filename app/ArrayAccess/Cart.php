<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace ArrayAccess;


class Cart extends \ArrayObject
{
    private $products = [];

    public function __construct()
    {

        parent::__construct($this->products);
    }

    public function getCommonPrice()
    {
        $price = 0;
        /**@var Product $product*/
        foreach ($this as $product) {
            $price += $product->getPrice();

        }
        return $price;
    }
}