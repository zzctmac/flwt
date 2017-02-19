<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/7
 * Time: 23:25
 */

include '../vendor/autoload.php';

$thumb = new \flwt\thumb\emmet\Impl();

$root = $thumb->getTree("#title");
$root->showTree();

$pattern = "(<[^/]*>)";

$str = "/<zzc>/<abc>";

preg_match_all($pattern, $str, $matches);

print_r($matches);