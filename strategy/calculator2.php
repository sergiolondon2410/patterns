<?php
//Basic Implementation of the Strategy Pattern and additional things
interface OperationInterface{
    public function doOperation($a, $b);
}

class AdditionStrategy implements OperationInterface{

    public function doOperation($a, $b){
        return $a + $b;
    }
}

class SubstractionStrategy implements OperationInterface{

    public function doOperation($a, $b){
        return $a - $b;
    }
}

class MultiplicationStrategy implements OperationInterface{

    public function doOperation($a, $b){
        return $a * $b;
    }
}

class Calculator{
    protected $operation;

    public function __construct(OperationInterface $operation = null)
    {
        $this->operation = $operation ?? new AdditionStrategy();
    }

    public function execute($a, $b){
        return $this->operation->doOperation($a, $b);
    }

    public function setOperation(OperationInterface $operation){
        $this->operation = $operation;
    }

    public function __call($method, $arguments){
        // $method = addition
        $classname = ucfirst($method) . 'Strategy';

        // $arguments = [5, 3]
        list($a, $b) = $arguments;

        $this->setOperation(new $classname);

        return $this->execute($a, $b);
    }
}

$calculator = new Calculator(new AdditionStrategy());

// $result = $calculator->addition(5, 3);
// $result = $calculator->substraction(5, 3);
$result = $calculator->multiplication(5, 3);

var_dump($result);