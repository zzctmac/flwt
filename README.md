# Framework L Web Test

**基于webdriver的前端测试框架**

## 使用步骤

### 定义页面

eg:
```php
class Login extends \flwt\wpd\Page
{
    protected $thumb = "form#login_form>input#username+input#password+input#submitBtn";
    protected $urlPattern = "/login.html";
}

class Valid extends Page
{
    protected $thumb = "h1#tip";
    protected $urlPattern = "/valid.php";
}

```

Login(继承Page的子类)中的`thumb`属性用来展示页面元素的缩略图，使用(Emmet)[http://docs.emmet.io/]来表示。`urlPattern` 表示该页面url的格式。

### 打开页面并模拟用户操作
eg:
```php
\dfb\Login::openNow();
\flwt\query\Emmet::get('#username')->input('zzc');
$alert = \flwt\query\Emmet::get('#password')->input('12345')->submit(1);
$alert->click();

```

### 使用phpunit进行测试

eg:

```php

PageClassManager::addClass(Login::class);
PageClassManager::addClass(Valid::class);
class PageTest extends extends PHPUnit_Framework_TestCase
{
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

        Login::openNow();
        Emmet::get('#username')->input($name);
        Emmet::get('#password')->input($password)->submit();
        $tip = Emmet::get('#tip');
        $this->assertEquals($expected, $tip->getText());
    }
}
```

## api 介绍 (TODO)


