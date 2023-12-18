<?php

namespace Calculator;

class Calculator
{
    public function __construct(private ArrayHandler $arrayHandler, private Validator $validator){}

    public function calculate(string $str):float
    {
        $array=$this->arrayHandler->convertToArray($str);
        $this->validator->checkParentheses($array);
        $this->validator->operationsCheck($array);
        $array=$this->fixMultiplication($array);
        $expression=$this->convertParenthesesToNodes($array);
        $expression=$this->convertToNode($expression);
        $expression=reset($expression);
        return $expression->calculate();
    }

    private function fixMultiplication(array $expression):array
    {
        $i=0;
        
        $iterator=new AroundIterator($expression);
        foreach($iterator as $key=>$item){
            
            if(in_array($item->getCurrent(), Parenthesis::getOpenedParentheses()) && is_numeric($item->getPrev())){
                $result=$this->arrayHandler->insertIntoArrayAfterPosition($expression, $i, '*');
                    
                    return $this->fixMultiplication($result);
            }
            if(in_array($item->getCurrent(), Parenthesis::getClosedParentheses()) && 
                (is_numeric($item->getNext()) || in_array($item->getNext(), Parenthesis::getOpenedParentheses())))
            {
                $result=$this->arrayHandler->insertIntoArrayAfterPosition($expression, $i+1, '*');
                    
                return $this->fixMultiplication($result);
            }
            $i++;
        }
        
        return $expression;
    }

    private function convertParenthesesToNodes(array $expression):array
    {
        $openedParentheses=Parenthesis::getOpenedParentheses();
        $closedParentheses=Parenthesis::getClosedParentheses();

        for($i=0;$i<count($openedParentheses);$i++){
            $parts=$this->arrayHandler->cutExpressionByParentheses($expression, $openedParentheses[$i], $closedParentheses[$i]);
            if(!$parts){
                continue;
            }
            
            $calc=$this->convertToNode($parts['part']);
    
            $begin=$parts['begin'];
            foreach($calc as $c){
                $begin[]=$c;
            }
            foreach($parts['end'] as $val){
                $begin[]=$val;
            }
            
            return $this->convertParenthesesToNodes($begin);
        }
        return $expression;
    }

    private function convertToNode(array $expression):array
    {
        $operators=Operator::getOperators();
        foreach($operators as $operator=>$prior){
            
            $iterator=new AroundIterator($expression);
            foreach($iterator as $key=>$item){
                if ($item->getCurrent() ==  $operator) {
                    $expression=$this->changeToNode($expression, $operator, $item);
                    
                    return $this->convertToNode($expression);
                }
            }
        }
        return $expression;
    }

    private function changeToNode(array $expression, string $operator, AroundItem $item):array
    {
        $node=new Node();
        $node->setOperation($operator);
        
        if(!is_string($item->getPrev())){
            $node->setNode1($item->getPrev());
        }else{
            $node->setNum1($item->getPrev());
        }
        if(!is_string($item->getNext() )){
            $node->setNode2($item->getNext());
        }else{
            $node->setNum2($item->getNext());
        }
    
        $expression[$item->getCurrentKey()]=$node;
        unset($expression[$item->getPrevKey()]);
        unset($expression[$item->getNextKey()]);

        return $expression;
    }
}