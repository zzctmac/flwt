<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/13
 * Time: 21:57
 */
include '../vendor/autoload.php';

$thumb = new \flwt\thumb\emmet\Impl();

$root = $thumb->getTree("(form#login>input#username.ip+input#password[tag=zzc]+input#submitBtn)+(a>h1)+a*4>h3");

$ps = $root->getElementById('password');

$xpathThumb = new \flwt\thumb\xpath\Impl();

echo $xpathThumb->getThumb($root, $ps);


