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
        \page\Vis::openNow();
        $btn = \flwt\query\Emmet::get('#btn');
        $div = \flwt\query\Emmet::get('#show');
        $res = $btn->click(5, \flwt\wait\Visibility::create($div));
        $this->assertTrue($div === $res);
    }
}
