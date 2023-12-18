<?php 

namespace Calculator;

class Factory
{
    public function create():Calculator
    {
        $arrayHandler=new ArrayHandler();
        $validator=new Validator();
        return new Calculator($arrayHandler, $validator);
    }
}