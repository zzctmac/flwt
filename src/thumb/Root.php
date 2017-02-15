<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/8
 * Time: 11:39
 */

namespace flwt\thumb;


use flwt\wpd\Node;

class Root extends Node
{
    protected $name = 'root';

    /**
     * @return Node|null
     */
    public function getSon()
    {
        return isset($this->elements[0]) ? $this->elements[0] : null; 
    }
}