<?php 

namespace Calculator;

class Symbols
{
    public static function getSymbols():array
    {
        $operators=Operator::getOperators();
        $openedParentheses=Parenthesis::getOpenedParentheses();
        $closedParentheses=Parenthesis::getClosedParentheses();
        for($i=0;$i<count($openedParentheses);$i++){
            $operators[$openedParentheses[$i]]=100+$i;
            $operators[$closedParentheses[$i]]=100+$i;
        }

        return $operators;
    }
}