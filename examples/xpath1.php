<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/15
 * Time: 14:33
 */

$str = "/home/dfb";

$pos = strrpos($str, "/");

$replace = "/" .  substr($str, $pos);

return  substr_replace($str, $replace, $pos);