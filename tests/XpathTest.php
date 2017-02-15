<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/15
 * Time: 21:38
 */
namespace {

    use dfb\DList;
    use dfb\Login;
    use Facebook\WebDriver\WebDriverBy;
    use flwt\PageClassManager;
    use flwt\Resource;

    class XpathTest extends PHPUnit_Framework_TestCase
    {

        public function test_index()
        {
            PageClassManager::addClass(Login::class);
            PageClassManager::addClass(DList::class);

            $page = new Login();
            $page->open();
            $htmlTree = $page->getHtmlTree();
            $nameInput = $htmlTree->getElementById('username');
            $pwdInput = $htmlTree->getElementById('password');
            $nameInput->input('zzc');
            $pwdInput->input('12345')->submit();
            $alert = $page->getAlert();
            $listPage = $alert->click();

            $driver = Resource::getGlobalDriver();
            $element = $driver->findElement(WebDriverBy::xpath("/html//ul[@class='list-group']/li[@class='list-group-item'][1]"));

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
