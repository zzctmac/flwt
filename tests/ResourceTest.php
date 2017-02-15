<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/11
 * Time: 22:23
 */
class ResourceTest extends PHPUnit_Framework_TestCase
{

    public function test_get_driver()
    {
        $driver = \flwt\Resource::getGlobalDriver();
        $this->assertTrue($driver instanceof \Facebook\WebDriver\WebDriver);
    }
}
