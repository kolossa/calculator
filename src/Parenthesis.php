<?php 

namespace Calculator;

class Parenthesis
{
    public static function getOpenedParentheses():array
    {
        return ['(','[','{'];
    }

    public static function getClosedParentheses() :array
    {
        return [')', ']', '}'];
    }
}