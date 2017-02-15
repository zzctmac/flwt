<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/8
 * Time: 22:04
 */
class EmmetTest extends PHPUnit_Framework_TestCase
{   
    public function test_parse()
    {
        $thumb = new \flwt\thumb\emmet\Impl();
        
        $root = $thumb->getTree('div#container>a#b[href=baidu]');
        
        $container = $root->getElementById('container');
        $link = $container->getElementById('b');
        
        $this->assertEquals($link->getUrl(), 'baidu');
    }
}
