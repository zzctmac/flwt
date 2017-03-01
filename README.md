# Framework L Web Test

**基于[webdriver](https://github.com/facebook/php-webdriver)的web测试框架**

## 使用步骤

### 定义页面

eg:
```php
class Login extends \flwt\wpd\Page
{
    protected $thumb = "form#login_form>input#username+input#password+input#submitBtn";
    protected $urlPattern = "/login.html";
}

class Valid extends \flwt\wpd\Page
{
    protected $thumb = "h1#tip";
    protected $urlPattern = "/valid.php";
}

```

继承Page的子类中的`thumb`属性用来展示页面元素的缩略图，使用[Emmet](http://docs.emmet.io/)来表示。`urlPattern` 表示该页面url的格式。

### 初始化等预备工作

eg:

```php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * 创建webdriver实例
 * 将用到的Page类添加到PageClassManager（方便跳转到新页面自动找到对应的Page类）
 * etc
 * 可以在phpunit中定义的bootstrap.php 做这些预备工作
**/


$host = 'http://localhost:4444/wd/hub'; // this is the default


$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities, 5000);

\flwt\UrlHandler::setPrefix("http://localhost");

\flwt\Resource::create($driver);

PageClassManager::addClass(Login::class);
PageClassManager::addClass(Valid::class);

```

### 打开页面并模拟用户操作
eg:
```php
\dfb\Login::openNow();
\flwt\query\Emmet::get('#username')->input('username');
$alert = \flwt\query\Emmet::get('#password')->input('password')->submit(1);
$alert->click();

```

### 使用phpunit进行测试

eg:

```php

class PageTest extends PHPUnit_Framework_TestCase
{
    public function submitDataProvider()
    {
        $data = array(
            array('u1', 'p1', 'success'),
            array('u2', 'p2', 'failed')
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

        Login::openNow();
        \flwt\query\Emmet::get('#username')->input($name);
        \flwt\query\Emmet::get('#password')->input($password)->submit();
        $tip = \flwt\query\Emmet::get('#tip');
        $this->assertEquals($expected, $tip->getText());
    }
}
```

## api 介绍 (TODO)


