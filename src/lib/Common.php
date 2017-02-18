<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/18
 * Time: 13:34
 */

namespace flwt\lib;

function cmp($a, $b)
{
    if(!is_array($a))
    {
        return $a === $b ? 0 : 1;
    }
    if(!is_array($b))
        return 1;
    return count(array_diff($a, $b)) == 0 && count(array_diff($b, $a)) == 0 ? 0 : 1;
}

class Common
{
    public static function arrayDiff($arr1, $arr2)
    {
        return count(array_udiff_assoc($arr1, $arr2, __NAMESPACE__ .  '\cmp')) == 0 && count(array_udiff_assoc($arr2, $arr1, __NAMESPACE__ . '\cmp')) == 0;
    }
}