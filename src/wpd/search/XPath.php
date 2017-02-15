<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/13
 * Time: 15:36
 */

namespace flwt\wpd\search;


use flwt\thumb\xpath\Impl;
use flwt\wpd\PageContainer;

trait XPath
{
    public function getXpath()
    {
        $page = PageContainer::top();
        $root = $page->getHtmlTree();
        $xpathThumb = new Impl();
        $xpath =  $xpathThumb->getThumb($root, $this);
        return $xpath;
    }
}