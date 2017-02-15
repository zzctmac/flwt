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
            $this->assertEquals(1, \flwt\wpd\PageContainer::count());
            $node = \flwt\wpd\PageContainer::top();
            $this->assertTrue($node instanceof Login);
        }
    }
}
namespace page {

    use flwt\wpd\Page;

    class Login extends Page
    {

        /**
         * Login constructor.
         */
        public function __construct()
        {
            parent::__construct("/login/<id>");
        }
    }
}