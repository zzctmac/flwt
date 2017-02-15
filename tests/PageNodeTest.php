<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/15
 * Time: 14:39
 */

namespace {

    use dfb\DList;
    use dfb\Login;
    use flwt\PageClassManager;

    class PageNodeTest extends PHPUnit_Framework_TestCase
    {

        public function test_load_node()
        {
            PageClassManager::addClass(Login::class);
            PageClassManager::addClass(DList::class);

            $page = new Login();
            $page->open();
            $htmlTree = $page->getHtmlTree();
            $nameInput = $htmlTree->getElementById('username');
            $pwdInput = $htmlTree->getElementById('password');
            $nameInput->input('zzc');
            $alert = $pwdInput->input('12345')->submit(1);

            $listPage = $alert->click();
            $this->assertTrue($listPage instanceof DList);
            $htmlTree = $listPage->getHtmlTree();
            $btn = $htmlTree->getElementById('logoutBtn');
            $this->assertTrue($btn->isDisPlayed());
            $this->assertEquals('button', $btn->getName());
            $btn->click();


        }
    }
}

namespace dfb
{
    use flwt\wpd\Page;

    class Login extends Page
    {
        protected $thumb = "div.container>form#login-form>input#username+input#password+button.btn+div#error>span#error_tip";
        protected $urlPattern = "/dfb/login.html";
    }

    class DList extends Page
    {
        protected $thumb = "div#container>button#logoutBtn";
        protected $urlPattern ="/dfb/list";
    }
}