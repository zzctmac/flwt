<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/5
 * Time: 17:18
 */

namespace flwt\wpd;


class Elements extends Node
{

    /**
     * Elements constructor.
     * @param $elements
     */
    public function __construct($elements)
    {
        $this->elements = $elements;
        $this->name = null;
    }

    /**
     * @param $index
     * @return Node|null
     */
    public function getElementByIndex($index)
    {
        return isset($this->elements[$index]) ? $this->elements[$index] : null; 
    }


}