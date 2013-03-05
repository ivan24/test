<?php
abstract class Tile
{
    abstract function getGold();
}
class Plains extends Tile
{
    private $gold = 2;

    public function getGold()
    {
        return $this->gold;
    }
}
abstract class TileDecorator extends Tile
{
    protected $tile;

    function __construct(Tile $tile)
    {
        $this->tile = $tile;
    }
}
class DiamondDecarator extends TileDecorator
{
    function getGold()
    {
        return $this->tile->getGold()+2;
    }
}
class PolutationDecarator extends TileDecorator
{
    function getGold()
    {
        return $this->tile->getGold()-4;
    }
}
$tile = new Plains();
print $tile->getGold();
print "<hr>";
$polution = new PolutationDecarator(new Plains());
print $polution->getGold();
print "<hr>";
$diamond = new DiamondDecarator(new Plains());
print $diamond->getGold();

