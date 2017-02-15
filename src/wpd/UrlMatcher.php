<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/7
 * Time: 0:45
 */

namespace flwt\wpd;


use zf\router\matcher\Simple;
use zf\router\route\WebFlag;

trait UrlMatcher
{
    protected function match($refer, $current)
    {
        $current = WebFlag::create($current);
        $refer = WebFlag::create($refer);
        $matcher = new Simple();
        return $matcher->match($refer, $current);
    }
}