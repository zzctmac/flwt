<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/4
 * Time: 21:00
 */

namespace flwt\wpd\nodes;


use flwt\wpd\Node;

class Link extends Node
{

    protected $name = 'a';
    
    protected $uselessForTwinAttrs = array('href');
    
    public function getUrl()
    {
        return $this->getAttr('href');
    }
}