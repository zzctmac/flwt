<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/5
 * Time: 17:41
 */

namespace flwt\wpd;


use Facebook\WebDriver\Exception\TimeOutException;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use flwt\Resource;
use flwt\thumb\emmet\Impl;
use flwt\thumb\IBase as IThumbBase;
use flwt\UrlHandler;
use flwt\wpd\nodes\Alert;

class Page
{

    
    protected $thumb;

    /**
     * @var IThumbBase
     */
    protected $thumbParser;

    protected $urlPattern;
    protected $currentUrl;
    
    
    

    /**
     * @var Node
     */
    protected $htmlTree;
    protected $title;

    /**
     * @var Alert
     */
    protected  $initAlert = null;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->initThumb();
    }
    
    public function initThumb()
    {
        $this->thumbParser = new Impl();
        $this->htmlTree = $this->thumbParser->getTree($this->thumb);
    }

    /**
     * @return Alert|null
     */
    public function open()
    {
        $driver = Resource::getGlobalDriver();
        
        $before = function() use($driver) {


            $fullUrl = UrlHandler::getFullUrl($this->urlPattern);

            $this->currentUrl = UrlHandler::removePrefix($fullUrl);
            
            $driver->get($fullUrl);
            PageContainer::push($this);


            $alert = $this->getAlert(0);
            if ($alert != null) {
                yield $alert;
            }
        };
        $after = function() use($driver) {
            self::loadInfoFromDriver($this, $driver);
        };
        
        $gen = $before();
        
        $res = $gen->current();
        $gen->send('');
        if($res instanceof Alert)
        {
            $res->setClickCallback($after);
            $this->initAlert = $res;
            return $res;
        }
        else
        {
            $after();
        }
            
    }
    
    public function getAlert($wait = 1)
    {
        $driver = Resource::getGlobalDriver();
        if($wait)
        {
            try {
                $driver->wait($wait)->until(WebDriverExpectedCondition::alertIsPresent());
            }
            catch (TimeOutException $e)
            {
                return null;
            }
        }
        $alert = $driver->switchTo()->alert();
        try{
            $alert->getText();
        }catch (\Exception $e)
        {
            return null;
        }
        return new Alert($alert);
    }
    
    public static function loadInfoFromDriver(Page $page, WebDriver $driver)
    {
        $page->setTitle($driver->getTitle());
        $htmlTree = $page->getHtmlTree();
        if($htmlTree != null)
        {
            Node::loadInfoFromDriver($htmlTree, $driver);
        }
    }
    
    use UrlMatcher;

    public function matchUrl($url)
    {
        return $this->match($this->urlPattern, $url);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return Node
     */
    public function getHtmlTree()
    {
        return $this->htmlTree;
    }

    /**
     * @return mixed
     */
    public function getCurrentUrl()
    {
        return $this->currentUrl;
    }

    /**
     * @return Alert
     */
    public function getInitAlert()
    {
        return $this->initAlert;
    }

    
    public function setInitAlert()
    {
        $this->initAlert = $this->getAlert(0);
    }
    

    /**
     * @param mixed $currentUrl
     */
    public function setCurrentUrl($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }
    
    public function wait($m = 1, $w = 0)
    {
        $driver = Resource::getGlobalDriver();
        $driver->wait($m, $w);
    }

    
}