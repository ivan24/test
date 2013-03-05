<?php
class Sea
{
}

class EarthSea extends Sea
{
}

class MarsSea extends Sea
{
}

class Plains
{
}

class EarthPlain extends Plains
{
}

class MarsPlain extends Plains
{
}

class Forest
{
}

class EarthForest extends Forest
{
}

class MarsForest extends Forest
{
}

class TerrainFactory
{
    private $sea;
    private $plains;
    private $forest;

    function __construct(Forest $forest, Plains $plains, Sea $sea)
    {
        $this->forest = $forest;
        $this->plains = $plains;
        $this->sea = $sea;
    }

    public function setForest($forest)
    {
        $this->forest = $forest;
    }

    public function getForest()
    {
        return $this->forest;
    }

    public function setPlains($plains)
    {
        $this->plains = $plains;
    }

    public function getPlains()
    {
        return $this->plains;
    }

    public function setSea($sea)
    {
        $this->sea = $sea;
    }

    public function getSea()
    {
        return $this->sea;
    }
}
 $factory = new TerrainFactory(new EarthForest(), new EarthPlain(), new EarthSea());
var_dump($factory->getForest());
var_dump($factory->getPlains());
var_dump($factory->getSea());