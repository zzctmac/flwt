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
        $title = \flwt\query\Emmet::get("#title");
        $this->assertEquals('登陆', $title->getText());
    }

    public function test_list()
    {
        $page = new \easy\DList();
        $page->open();
        $as = \flwt\query\Emmet::getMulti('a');
        $this->assertEquals(3, $as->getElementCount());

        $a1= $as->getElementByIndex(0);
        $this->assertEquals('baidu', $a1->getText());

    }

    public function test_list_class()
    {
        $page = new \easy\DList();
        $page->open();
        $as = \flwt\query\Emmet::getMulti('a.zz');
        $this->assertEquals(1, $as->getElementCount());
        $a1 = $as->getElementByIndex(0);
        $this->assertEquals('baidu', $a1->getText());
        $a1 = \flwt\query\Emmet::get('a.zz');
        $this->assertEquals('baidu', $a1->getText());
    }


}
