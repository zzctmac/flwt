<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/15
 * Time: 21:29
 */
$arr1 = array('name'=>'zzc', 'id'=>'1', 'class'=>array('tmac', 'zzc'));
$arr2 = array('name'=>'zzc', 'id'=>'1', 'class'=>array('zzc', 'tmac'));

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

var_dump(array_udiff_assoc($arr1, $arr2, 'cmp'));
var_dump(array_udiff_assoc($arr2, $arr1, 'cmp'));