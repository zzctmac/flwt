<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/12
 * Time: 18:00
 */

namespace flwt\wpd\nodes;


use Facebook\WebDriver\WebDriverAlert;
use flwt\wpd\Node;
use flwt\wpd\PageContainer;

class Alert extends Node
{
    protected $driverAlert;
    protected $clickCallback = null;

    /**
     * Alert constructor.
     * @param WebDriverAlert $alert
     */
    public function __construct(WebDriverAlert $alert)
    {
        $this->driverAlert = $alert;
    }

    /**
     * @param int $wait
     * @param null $waitFor
     * @return Alert|\flwt\wpd\Page|null
     */
    public function click($wait = 0, $waitFor =  null)
    {
        $this->driverAlert->accept();
        if($this->clickCallback != null)
            call_user_func($this->clickCallback);
        
      return self::clickResp($wait, $waitFor);
    }

    public function getText($cache = 0)
    {
        return $this->driverAlert->getText();
    }

    public function setValue($value)
    {
        $this->driverAlert->sendKeys($value);
        return $this;
    }
    
    public function dismiss()
    {
        $this->driverAlert->dismiss();
        return $this;
    }

    /**
     * @param null $clickCallback
     */
    public function setClickCallback($clickCallback)
    {
        $this->clickCallback = $clickCallback;
    }


}