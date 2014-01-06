<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace ArrayAccess;


class Product 
{
    protected $id;
    protected $price;
    protected $description;

    function __construct($id, $price, $description)
    {
        $this->id = $id;
        $this->price = $price;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }


} 