<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/6
 * Time: 23:42
 */

namespace {

    use Facebook\WebDriver\WebDriverBy;
    use flwt\PageClassManager;
    use flwt\Resource;
    use page\Alert;
    use page\ClickAlert;
    use page\Login;

    class PageTest extends PHPUnit_Framework_TestCase
    {

        public function test_url_match()
        {
            $page = new Login();
            $url = "/login.html";
            $res = $page->matchUrl($url);
            
            $this->assertFalse(!$res);
        }

        public function test_title_url()
        {
            $page = new Login();
            $page->open();
            $title = $page->getTitle();

            $this->assertEquals('login', $title);
        }

        public function test_submit()
        {
            $data = array(
                array('zzc', '123456', 'success'),
                array('zzc', '12345', 'failed')
            );
            foreach ($data as $info)
                $this->submitInfo($info);
        }

        private function submitInfo($info)
        {
            $page = new Login();
            $page->open();
            $driver = \flwt\Resource::getGlobalDriver();
            $htmlTree = $page->getHtmlTree();
            $htmlTree->getElementById('username')->input($info[0]);
            $htmlTree->getElementById('password')->input($info[1])->submit();
            $tip = $driver->findElement(WebDriverBy::id('tip'));
            $this->assertEquals($info[2], $tip->getText());
        }

        public function test_alert()
        {
            $page = new Alert();
            $alert = $page->open();
            $this->assertTrue($alert != null );
            $this->assertEquals('zzc', $alert->getText());
            $alert->click();
            $tree = $page->getHtmlTree();
            $div = $tree->getElementById("tip");
            $this->assertEquals('zzc', $div->getText());
        }

        public function test_click_alert()
        {
            $page = new ClickAlert();
            $page->open();
            $htmlTree = $page->getHtmlTree();
            $btn = $htmlTree->getElementById('btn');
            $alert = $btn->click(1);
            $this->assertTrue($alert != null);
            $this->assertEquals('ca', $alert->getText());
            $alert->click();
        }



        public function test_redirect()
        {
            PageClassManager::addClass(\dfb\Login::class);
            PageClassManager::addClass(\dfb\DList::class);

            //$driver = \flwt\Resource::getGlobalDriver();
            $login = new \dfb\Login();
            $login->open();


            $htmlTree = $login->getHtmlTree();

            $usernameInput = $htmlTree->getElementById('username');
            $passwordInput = $htmlTree->getElementById("password");
            $usernameInput->input('zzc');
            $alert = $passwordInput->input('12345')->submit(3);


            //print_r($driver->getWindowHandles());

            
            $list = $alert->click();

            $this->assertEquals('/dfb/list', $list->getCurrentUrl());
            $htmlTree = $list->getHtmlTree();
            $element = $htmlTree->getElementById('logoutBtn');
            $newLogin = $element->click();
            $this->assertEquals('/dfb/login.html', $newLogin->getCurrentUrl());
            $this->assertTrue($newLogin instanceof \dfb\Login);
        }

        public function test_open_2()
        {
            $login = new \dfb\Login();
            $login->open();
            $login->open();
        }


    }
}





