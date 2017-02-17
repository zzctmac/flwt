<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/17
 * Time: 16:13
 */
class EmmetQueryTest extends PHPUnit_Framework_TestCase
{

    public function test_query_id()
    {
        $page = new \dfb\Login();
        $page->open();
        $title = \flwt\query\Emmet::get("#title")->getText();
        $this->assertEquals('登陆', $title);
    }
}
