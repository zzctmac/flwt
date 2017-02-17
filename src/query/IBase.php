<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/17
 * Time: 16:10
 */

namespace flwt\query;


use flwt\wpd\Elements;
use flwt\wpd\Node;

interface IBase
{
    /**
     * @param $thumb
     * @return Node|null
     */
    public static function get($thumb);

    /**
     * @param $thumb
     * @return Elements|null
     */
    public static function getMulti($thumb);
}