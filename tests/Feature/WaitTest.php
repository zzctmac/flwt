<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/19
 * Time: 17:36
 */




class WaitTest extends \PHPUnit_Framework_TestCase
{

    public function test_visibility()
    {
        $page = \page\Vis::openNow();
        $btn = \flwt\query\Emmet::get('#btn');
        $res = $btn->click(1, \flwt\wait\Visibility::create($btn));
        $this->assertTrue($btn === $res);
    }
}
