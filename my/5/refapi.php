<?php
header("Content-type:text/html;charset=utf-8");
class ShopProduct
{
    private $title;
    private $producerMainName;
    private $producerFirstName;
    protected $price;
    private $discount = 0;

    public function __construct(
        $title,
        $firstName,
        $mainName,
        $price
    ) {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
    }

    public function getProducerFirstName()
    {
        return $this->producerFirstName;
    }

    public function getProducerMainName()
    {
        return $this->producerMainName;
    }

    public function setDiscount($num)
    {
        $this->discount = $num;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPrice()
    {
        return ($this->price - $this->discount);
    }

    public function getProducer()
    {
        return "{$this->producerFirstName}" .
            " {$this->producerMainName}";
    }

    public function getSummaryLine()
    {
        $base = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        return $base;
    }
}

class CdProduct extends ShopProduct
{
    private $playLength = 0;

    public function __construct(
        $title,
        $firstName,
        $mainName,
        $price,
        $playLength
    ) {
        parent::__construct(
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->playLength = $playLength;
    }

    public function getPlayLength()
    {
        return $this->playLength;
    }

    public function getSummaryLine()
    {
        $base = parent::getSummaryLine();
        $base .= ": playing time - {$this->playLength}";
        return $base;
    }

}

class BookProduct extends ShopProduct
{
    private $numPages = 0;

    public function __construct(
        $title,
        $firstName,
        $mainName,
        $price,
        $numPages
    ) {
        parent::__construct(
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->numPages = $numPages;
    }

    public function getNumberOfPages()
    {
        return $this->numPages;
    }

    public function getSummaryLine()
    {
        $base = parent::getSummaryLine();
        $base .= ": page count - {$this->numPages}";
        return $base;
    }

    public function getPrice()
    {
        return $this->price;
    }
}

class ReflectionIvan
{
    /** @var ReflectionClass $class*/
    static function getClassSource(ReflectionClass $class)
    {
        $path = $class->getFileName();
        $lines = file($path);
        $from = $class->getStartLine();
        $to = $class->getEndLine();
        $len = $to-$from+1;
        return implode(array_slice($lines,$from-1,$len));
    }
}
/** @var ReflectionClass $class*/
function classData(ReflectionClass $class)
{
    $name = $class->getName();
    $details = '';

    if ( $class->isUserDefined()){
        $details .= "$name определнный пользователем класс\n";
    }

    if($class->isInternal()){
        $details .= "$name класс определнён системой\n";
    }

    if($class->isInterface()){
        $details .= "$name это интерфейс\n";
    }

    if($class->isAbstract()){
        $details .= "$name это абстрактный класс\n";
    }

    if($class->isInstantiable()){
        $details .= "$name можно создать экземпляр класса\n";
    }else {
        $details .= "$name -- нельзя создать экземпляр класса\n";
    }
    return $details;
}
$ref_class = new ReflectionClass('CDProduct');

echo ReflectionIvan::getClassSource($ref_class);
