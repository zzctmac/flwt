<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/15
 * Time: 23:53
 */
namespace {

    use easy\DList;

    class MultiNodeTest extends PHPUnit_Framework_TestCase
    {
        public function test_easy()
        {
            $page = new DList();
            $page->open();
            $htmlTree = $page->getHtmlTree();
            $lis = $htmlTree->getElementsByTagName('li');
            $li = $lis->getElementByIndex(0);
            $this->assertEquals(1, $li->getText());
        }
    }
}

namespace easy
{

    use flwt\wpd\Page;

    class DList extends Page
    {
        protected $thumb = "ul>li*2";
        protected $urlPattern = "/list.html";
    }
}