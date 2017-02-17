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
            $as = $htmlTree->getElementsByTagName('a');
            $a = $as->getElementByIndex(0);
            $this->assertEquals('baidu', $a->getText());
            $baiduPage = $a->click();
            $this->assertEquals("https://www.baidu.com/", $baiduPage->getCurrentUrl());
            unset($a);
            unset($as);

            $page->open();
            $lis = $htmlTree->getElementsByTagName('li');
            $li = $lis->getElementByIndex(1);
            $a = $li->getElementsByTagName('a')->getElementByIndex(0);
            $this->assertEquals("weibo", $a->getText());
            
        }
    }
}

namespace easy
{

    use flwt\wpd\Page;

    class DList extends Page
    {
        protected $thumb = "ul>li*n>a";
        protected $urlPattern = "/list.html";
    }
}