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
            $alert = $passwordInput->input('12345')->submit(1);


            //print_r($driver->getWindowHandles());

            
            $list = $alert->click();

            $this->assertEquals('/dfb/list', $list->getCurrentUrl());
            $htmlTree = $list->getHtmlTree();
            $element = $htmlTree->getElementById('logoutBtn');
            $newLogin = $element->click();
            $this->assertEquals('/dfb/login.html', $newLogin->getCurrentUrl());
            $this->assertTrue($newLogin instanceof \dfb\Login);
        }


    }
}


namespace dfb
{
    use flwt\wpd\Page;

    class Login extends Page
    {
        protected $thumb = "div.container>div.row>div.col-sm-6.col-sm-offset-6.form-box>div.form-bottom>form#login-form>(div.form-group>input#username)+(div.form-group>input#password)+button.btn+div#error>span#error_tip";
        protected $urlPattern = "/dfb/login.html";
    }

    class DList extends Page
    {
        protected $thumb = "div#container>a[href=logout]>button#logoutBtn";
        protected $urlPattern ="/dfb/list";
    }
}


namespace page {

    use flwt\wpd\Page;

    class Login extends Page
    {
        protected $thumb = "form#login_form>input#username+input#password+input#submitBtn";
        protected $urlPattern = "/login.html";
    }
    
    class Alert extends Page
    {
        protected $thumb = 'div#tip';
        protected $urlPattern = "/alert.html";
    }

    class ClickAlert extends Page
    {
        protected $thumb = "div#tip+button#btn";
        protected $urlPattern = "/click_alert.html";
    }
}