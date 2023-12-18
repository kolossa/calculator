<?php 

namespace Calculator;

class Operator
{
    private static array $multiplication=[
        '*',
        '×',
        '⋅',
    ];

    private static array $division=[
        '/',
        '÷',
    ];

    private static string $addition='+';
    private static string $subtraction= '-';
    private static ?array $operators=null;
    public static function getOperators():array
    {
        if(self::$operators===null){
            
            $operators=[];
            foreach(self::$multiplication as $operator){
                $operators[$operator]=10;
            }
            foreach(self::$division as $operator){
                $operators[$operator]= 10;
            }
            $operators[self::$subtraction]=1;
            $operators[self::$addition]= 0;
            
            uasort($operators, fn($a, $b)=>$a<$b);
            self::$operators=$operators;
        }
        
        return self::$operators;
    }

    public static function getMultiplication():array
    {
        return self::$multiplication;
    }

    public static function getDivision():array
    {
        return self::$division;
    }

    public static function getSubtraction():string
    {
        return self::$subtraction;
    }

    public static function getAddition():string
    {
        return self::$addition;
    }
}