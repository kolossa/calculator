<?php 

namespace Calculator;

class AroundItem
{
    public function __construct(
        private $currentKey, 
        private $current, 
        private $nextKey,
        private $next,
        private $prevKey,
        private $prev
    ){}

    public function getCurrentKey()
    {
        return $this->currentKey;
    }

    public function getCurrent()
    {
        return $this->current;
    }

    public function getNextKey()
    {
        return $this->nextKey;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function getPrevKey()
    {
        return $this->prevKey;
    }

    public function getPrev()
    {
        return $this->prev;
    }


}