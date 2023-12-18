<?php 

namespace Calculator;

class AroundIterator implements \Iterator
{
    private bool $first=true;

    public function __construct(private array $array) {
    }

    public function rewind() 
    {
        reset($this->array);
        $this->first=true;
    }
	
	public function current() :AroundItem
    {
        if($this->first){
            $this->first=false;
            $prev=false;
            $prevKey=false;
        }else{
            $prev=prev($this->array);
            $prevKey=key($this->array);
            next($this->array);
        }
        $current= current($this->array);
        $currentKey=key($this->array);
        $next=next($this->array);
        $nextKey=key($this->array);
        prev($this->array);
        
        return new AroundItem($currentKey, $current, $nextKey, $next, $prevKey, $prev);
    }
	
	public function key() 
    {
        return key($this->array);
    }

    public function next() 
    {
        next($this->array);
    }

    public function valid() 
    {
        return key($this->array) !== null;
    }
}