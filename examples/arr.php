<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/15
 * Time: 21:29
 */
$a1 = array('zzc', 'lsh');
$a2 = array('lsh', 'zzc');

print_r(array_diff($a1, $a2));

$arr = array(1, 2, 3, 4, 1);

foreach ($arr as $k=>$v)
{
    if($v == 1) {
        $arr[] = 3;
        $arr[] = 3;
    }
    echo $k.'=>'.$v."\n";
}