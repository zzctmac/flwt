<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/17
 * Time: 16:13
 */

namespace flwt\query;



use flwt\wpd\Elements;
use flwt\wpd\Node;

class Emmet implements IBase
{

    /**
     * @param $thumb
     * @param Node|null $root
     * @return Node|null
     */
    public static function get($thumb, $root = null)
    {
        $elements = self::getMulti($thumb);
        return $elements->getElementByIndex(0);
    }

    /**
     * @param $thumb
     * @param Node|null $root
     * @return Elements|null
     */
    public static function getMulti($thumb, $root = null)
    {
        $thumbHandler = new EmmetHandler();
        $tree = $thumbHandler->getTree($thumb);
        return self::getElementsByHtmlTree($tree, $root);
    }
    
    use ElementSearch;
}