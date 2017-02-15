<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/11
 * Time: 10:17
 */

namespace flwt\wpd;
use flwt\PageClassManager;
use flwt\Resource;
use flwt\UrlHandler;


/**
 * Class PageContainer
 * @package flwt\wpd
 * @method  static Page  pop();
 * @method static Page push(Page $page);
 * @method static count();
 * @method static isEmpty();
 * @method  static Page  top();
 */
final class PageContainer
{
    /**
     * @var \SplStack[]
     */
    private $stacks;
    
    private $currentHandle;

    private function __construct()
    {
        $this->stacks = array();
    }

    public function ppush(Page $page)
    {
        $driver = Resource::getGlobalDriver();
        $handle = $driver->getWindowHandle();
        $this->currentHandle = $handle;
        if(!isset($this->stacks[$handle]))
        {
            $this->stacks[$handle] = new \SplStack();
        }
        $this->stacks[$handle]->push($page);
    }

    public function ppop()
    {
        $this->stacks[$this->currentHandle]->pop();
    }

    public function pcount()
    {
        return $this->stacks[$this->currentHandle]->count();
    }

    public function pisEmpty()
    {
        return $this->stacks[$this->currentHandle]->isEmpty();
    }

    public function ptop()
    {
        return $this->stacks[$this->currentHandle]->top();
    }


    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this, 'p' . $name), $arguments);
    }
    
    private static $ins;

    /**
     * @return PageContainer
     */
    public static function getInstance()
    {
        if(!self::$ins instanceof self)
        {
            self::$ins = new self();
        }
        return self::$ins;
    }
    
    public static function __callStatic($name, $arguments)
    {
        $ins = self::getInstance();
        return call_user_func_array(array($ins, $name), $arguments);
    }
    
    public static function tryRedirect()
    {
        $page = self::top();
        $driver = Resource::getGlobalDriver();
        $currentUrl = UrlHandler::removePrefix($driver->getCurrentURL());
        if($page->getCurrentUrl() == $currentUrl)
            return ;
        $class = PageClassManager::map($currentUrl);
        if($class == null)
        {
            $newPage = new Page();
            $newPage->setCurrentUrl($currentUrl);
            $newPage->setInitAlert();
            $newPage->setCurrentUrl($currentUrl);
            self::push($newPage);
        }
        else
        {
            $newPage = new $class();
            $newPage->setCurrentUrl($currentUrl);
            $newPage->setInitAlert();
            self::push($newPage);
            Page::loadInfoFromDriver($newPage, $driver);
        }

        
        
    }
    
    
}