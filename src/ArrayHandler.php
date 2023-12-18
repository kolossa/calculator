<?php 

namespace Calculator;

class ArrayHandler
{
    public function convertToArray(string $str):array
    {
        $operators=Symbols::getSymbols();
        $openedParentheses=Parenthesis::getOpenedParentheses();
        $operators=array_keys($operators);
        $result=[];
        $number='';
        $first=true;
        $chars=mb_str_split($str);
        $iterator=new AroundIterator($chars);
        foreach ($iterator as $key=>$item) {
            if($first){
                $first=false;
                //if the first character is '-', then it is not an operator, but a negative number
                if($item->getCurrent() == '-'){
                    $number.=$item->getCurrent();
                    continue;
                }
            }
            if(in_array($item->getCurrent(), $operators)){
                //if the first character after an opened parenthesese is '-', then it is not an operator, but a negative number
                if($item->getCurrent()=='-' && in_array($item->getPrev(), $openedParentheses)){
                    $number.=$item->getCurrent();
                    continue;    
                }
                
                if($number!=''){
                    $result[]=$number;
                }
                $result[]=$item->getCurrent();
                $number='';
            }else{
                $number.=$item->getCurrent();
            }
        }

        if($number!= ''){
            $result[]=$number;
        }

        return $result;
    }

    public function insertIntoArrayAfterPosition(array $array, int $position ,string $value):array
    {
        $end=array_slice($array, $position);
        $start=array_slice($array,0, $position);
        $start[]=$value;
        return array_merge($start, $end);
    }

    public function cutExpressionByParentheses(array $expression, string $from, string $to):?array
    {
        $start=false;
        foreach($expression as $key=>$val){
            if($val==$from){
                $start=$key;
            }
        }
        $end=false;
        foreach($expression as $key=>$val){
            if($key>=$start && $val==$to){
                $end=$key;
                break;
            }
        }
        if($start===false || $end===false){
            return null;
        }

        $part=[];
        foreach($expression as $key=>$val){   
            if($key>$start && $key<$end){
                $part[]=$val;
                unset($expression[$key]);
            }
        }

        unset($expression[$start], $expression[$end]);

        $endOfExpression=[];
        foreach($expression as $key=>$val){
            if($key>$end){
                $endOfExpression[]=$val;
                unset($expression[$key]);
            }
        }

        return [
            'begin'=>$expression,
            'part'=>$part,
            'end'=>$endOfExpression,
        ];
    }
}