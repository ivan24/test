<?php
header("Content-Type:text/html;charset=utf-8");
class Product
{
    public $name;
    public $price;

    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale
{
    private $callbacks;

    function registerCalback($callback)
    {
        if (!is_callable($callback)) {
            throw new Exception("Не вызываемая функция обратного вызова");
        }
        $this->callbacks[] = $callback;
    }

    function sale($product)
    {
        print "обрабатывается {$product->name}\n";
        foreach ($this->callbacks as $callbak) {
            call_user_func($callbak, $product);
        }
        print "\n";
    }
}
class Totalizer
{
    static function warnAmount($amt)
    {
        $count = 0 ;
        return function($product) use ($amt, &$count){
            $count += $product->price;
            print "\tсумма: $count\n";
            if ($count>$amt) {
                print "\tПроданно товаров на сумму: {$count} \n";
            }
        };
    }
}
class Mailer
{
    public function doMail($product)
    {
        print "\tУпаковываем {$product->name}\n";
    }
}
$logger = create_function('$product','print "\tЗаписываем ....({$product->name})\n";');
$price =  function($product){
    print "\tThis product cost:".$product->price;
    print "\n";
};
$processor = new ProcessSale();


$processor->registerCalback($logger);
$processor->registerCalback($price);
$processor->registerCalback(array(new Mailer(),'doMail'));
$processor->registerCalback(Totalizer::warnAmount(400));

$processor->sale(new Product('boots',45));
$processor->sale(new Product('Tshirts',5));
$processor->sale(new Product('coat',67));
$processor->sale(new Product('palls',87));
$processor->sale(new Product('reader',280));