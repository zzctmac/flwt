<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/7
 * Time: 22:56
 */

namespace flwt\thumb;


trait StringTraversal
{
    public static function getStringIterator($string)
    {
        $len = strlen($string);
        for($i = 0; $i < $len; $i++)
            yield $string[$i];
    }
}