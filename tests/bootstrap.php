<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/4
 * Time: 21:05
 */

namespace {
    include './vendor/autoload.php';
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

namespace dfb
{
    use flwt\wpd\Page;

    class Login extends Page
    {
        protected $thumb = "div.container>p#title+form#login-form>input#username+input#password+button.btn+div#error>span#error_tip";
        protected $urlPattern = "/dfb/login.html";
    }

    class DList extends Page
    {
        protected $thumb = "div#container>button#logoutBtn";
        protected $urlPattern ="/dfb/list";
    }
}
namespace {

    use Facebook\WebDriver\Remote\DesiredCapabilities;
    use Facebook\WebDriver\Remote\RemoteWebDriver;



    $host = 'http://localhost:4444/wd/hub'; // this is the default


    $capabilities = DesiredCapabilities::chrome();
    $driver = RemoteWebDriver::create($host, $capabilities, 5000);

    \flwt\UrlHandler::setPrefix("http://localhost");

    \flwt\Resource::create($driver);
}