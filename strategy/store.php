<?php

interface DiscountInterface{
    public function calculateDiscount($price);
}

class FullPrice implements DiscountInterface{
    
    public function calculateDiscount($price){
        return 0;
    }
}

class TenPercent implements DiscountInterface{

    public function calculateDiscount($price):int{
        return ceil($price * 0.1);
    }
}

class TwentyfivePercent implements DiscountInterface{

    public function calculateDiscount($price):int{
        return ceil($price * 0.25);
    }
}

class FiftyPercent implements DiscountInterface{

    public function calculateDiscount($price):int{
        return ceil($price * 0.5);
    }
}

class Store{
    protected $discount;
    public int $discount_calculated = 0;
    public int $price = 0;

    public function __construct(DiscountInterface $discount = null)
    {   
        $this->discount = $discount ?? new FullPrice();
    }

    public function execute($price){
        $this->price = $price;
        $this->discount_calculated = $this->discount->calculateDiscount($price);
        return $this->discount_calculated;
    }

    public function setDiscount(discountInterface $discount){
        $this->discount = $discount;
    }

    public function getTotal():int{
        return $this->price - $this->discount_calculated;
    }

    public function __call($method, $arguments){
        // $method = twentyfive
        $classname = ucfirst($method) . 'Percent';

        // $arguments = [52]
        list($price) = $arguments;

        $this->setDiscount(new $classname);

        return $this->execute($price);
    }

}

// $store = new Store();
// $store = new Store(new TenPercent());
$store = new Store(new TwentyfivePercent());
// $discount = $store->execute(52);
// $discount = $store->twentyfive(52);
$discount = $store->fifty(52);

echo "Price: {$store->price}$, Discount: {$store->discount_calculated}$, Total Price: {$store->getTotal()}$";
// var_dump($total);