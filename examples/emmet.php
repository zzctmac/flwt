<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/7
 * Time: 23:25
 */

include '../vendor/autoload.php';

$thumb = new \flwt\thumb\emmet\Impl();

$root = $thumb->getTree("div.container>div.row>div.form-box>form#login-form>(div.form-group>input#password)+(div.form-group>input#password)+button.btn+div#error>span#error_tip");
$root->showTree();