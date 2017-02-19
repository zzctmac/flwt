<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/19
 * Time: 17:07
 */

namespace flwt\wait;


use flwt\wpd\PageContainer;

class Alert extends Base
{

   

    

    public static function create()
    {
        return new static();
    }

    public function getRes($wait)
    {
        $page = PageContainer::top();
        $alert = $page->getAlert($wait);
        if($alert != null)
        {
            $alert->setClickCallback(function(){
                PageContainer::tryRedirect();
            });
        }
        return $alert;
    }
}