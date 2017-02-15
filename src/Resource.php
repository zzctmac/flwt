<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/11
 * Time: 22:16
 */

namespace flwt;


use Facebook\WebDriver\WebDriver;

class Resource
{
    /**
     * @var WebDriver
     */
    protected $driver;
    
    protected function __construct(WebDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @var self
     */
    protected static $ins;
    
    public static function create(WebDriver $driver)
    {
        static::$ins = new static($driver);
    }
    
    public function getDriver()
    {
        return $this->driver;
    }
    
    public static function getGlobalDriver()
    {
        return static::$ins->getDriver();
    }
    
    public function __destruct()
    {

        $this->driver->close();
    }
}