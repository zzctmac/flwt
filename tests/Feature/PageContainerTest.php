<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/11
 * Time: 10:25
 */
namespace {

    use page\Login;

    class PageContainerTest extends PHPUnit_Framework_TestCase
    {
        public function test_stack()
        {
            \flwt\wpd\PageContainer::push(new Login());
            $node = \flwt\wpd\PageContainer::top();
            $this->assertTrue($node instanceof Login);
        }
    }
}