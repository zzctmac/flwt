<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/6
 * Time: 23:42
 */

namespace {

    use Facebook\WebDriver\WebDriverBy;
    use flwt\PageClassManager;
    use flwt\query\Emmet;
    use flwt\Resource;
    use page\Alert;
    use page\ClickAlert;
    use page\Detail;
    use page\Login;
    use page\Reload;
    use page\Valid;

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

        public function submitDataProvider()
        {
            $data = array(
                array('zzc', '123456', 'success'),
                array('zzc', '12345', 'failed')
            );
            return $data;
        }

        /**
         * @dataProvider submitDataProvider
         * @param $name
         * @param $password
         * @param $expected
         */
        public function test_submit($name, $password, $expected)
        {
            PageClassManager::addClass(Login::class);
            PageClassManager::addClass(Valid::class);
            Login::openNow();
            Emmet::get('#username')->input($name);
            Emmet::get('#password')->input($password)->submit();
            $tip = Emmet::get('#tip');
            $this->assertEquals($expected, $tip->getText());
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

        public function test_url_regex()
        {

            Detail::openNowWithoutWait(2);
            $h1 = Emmet::get('h1');
            $this->assertEquals('2', $h1->getText());
        }

        public function test_reload()
        {
            $page = Reload::openNow();
            $btn= Emmet::get('button');
            $btn->click()->forceFresh();
            $h1 = Emmet::get('h1');
            $this->assertEquals('zzc', $h1->getText());

        }

        public function test_l1()
        {
            \dfb\Login::openNow();
            \flwt\query\Emmet::get('#username')->input('zzc');
            $alert = \flwt\query\Emmet::get('#password')->input('12345')->submit(1);
            $alert->click();
        }

    }
}





