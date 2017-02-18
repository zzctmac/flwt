<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/7
 * Time: 22:48
 */

namespace flwt\wpd\nodes;


use flwt\wpd\Node;

class Normal extends Node
{
    protected $name = 'normal';

   

    /**
     * @param string $name
     */
    public function setName($name)
    {
        if($name != '')
        $this->name = $name;
    }
    
    
}