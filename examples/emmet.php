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