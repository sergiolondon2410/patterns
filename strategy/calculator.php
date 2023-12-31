<?php
//Basic Implementation of the Strategy Pattern
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
}

$calculator = new Calculator(new AdditionStrategy());
$calculator->setOperation(new SubstractionStrategy());
$result = $calculator->execute(5, 3);

var_dump($result);