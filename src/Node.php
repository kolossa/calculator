<?php 

namespace Calculator;

class Node
{
    private ?int $num1 = null;
    private ?int $num2 = null;
    private ?node $node1 = null;
    private ?node $node2 = null;
    private string $operation;

    public function calculate ():int
    {

        if ($this->num1 === null) {
            $this->num1 = $this->node1->calculate();
        }
        if ($this->num2 === null) {
            $this->num2 = $this->node2->calculate();
        }

        if(in_array($this->operation, Operator::getMultiplication())){
            return $this->num1 * $this->num2;
        }elseif(in_array($this->operation, Operator::getDivision())){
            return $this->num1 / $this->num2;
        }elseif(Operator::getSubtraction()==$this->operation){
            return $this->num1 - $this->num2;
        }elseif(Operator::getAddition()==$this->operation){
            return $this->num1 + $this->num2;
        }

        throw new \Exception('operator is not processed: '.$this->operation);
    }

    public function getNum1(): int{ 
        return $this->num1;
    }

    public function setNum1(int $num1): void
    {
        $this->num1 = $num1;
    }

    public function getNum2(): int{
        return $this->num2;
    }

    public function setNum2(int $num2): void
    {
        $this->num2=$num2;
    }

    public function getNode1(): node{
        return $this->node1;
    }

    public function setNode1(node $node1): void
    {
        $this->node1 = $node1;
    }

    public function getNode2(): node{
        return $this->node2;
    }

    public function setNode2(node $node2): void
    {
        $this->node2 = $node2;
    }

    public function getOperation(): string{    
        return $this->operation;
    }

    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }
}