<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/17
 * Time: 16:13
 */

namespace flwt\query;


use flwt\thumb\emmet\Impl;
use flwt\wpd\Elements;
use flwt\wpd\Node;

class Emmet implements IBase
{

    /**
     * @param $thumb
     * @return Node|null
     */
    public static function get($thumb)
    {
        $elements = self::getMulti($thumb);
        return $elements->getElementByIndex(0);
    }

    /**
     * @param $thumb
     * @return Elements|null
     */
    public static function getMulti($thumb)
    {
        $thumbHandler = new EmmetHandler();
        $tree = $thumbHandler->getTree($thumb);
        return self::getElementsByHtmlTree($tree);
    }
    
    use ElementSearch;
}