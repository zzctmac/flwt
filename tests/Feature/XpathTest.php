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
            $alert = $page->getAlert(3);
            $listPage = $alert->click();

        }
    }
}


