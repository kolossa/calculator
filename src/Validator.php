<?php 

namespace Calculator;

class Validator
{
    public function checkParentheses(array $expression):void
    {
        $num=[];
        $embedTypesOpened=[];
        foreach ($expression as $value) {
            foreach(Parenthesis::getOpenedParentheses() as $key=>$parenthesis){
                if($value==$parenthesis){
                    if(!isset($num[$key])){
                        $num[$key]=0;
                    }
                    $num[$key]++;
                    $embedTypesOpened[]=$parenthesis;

                }
            }
            foreach(Parenthesis::getClosedParentheses() as $key=>$parenthesis){
                if($value==$parenthesis){
                    if(!isset($num[$key])){
                        $num[$key]=0;
                    }
                    $num[$key]--;
                    if(array_pop($embedTypesOpened)!=Parenthesis::getOpenedParentheses()[$key]){
                        throw new ParenthesesException();
                    }
                    if($num[$key]<0){
                        throw new ParenthesesException();
                    }
                }
            }
        }
        foreach($num as $value) {
            if($value!=0){
                throw new ParenthesesException();
            }
        }
    }

    public function operationsCheck(array $expression)
    {
        $operators=array_keys(Symbols::getSymbols());
        foreach($expression as $value) {
            if(!in_array($value, $operators) && !is_numeric($value)){
                throw new UnknownOperatorException('unknown operator: "'.$value.'"');
            }
        }
    }
}