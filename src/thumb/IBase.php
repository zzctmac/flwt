<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/7
 * Time: 21:56
 */

namespace flwt\thumb;namespace flwt\thumb;


use flwt\wpd\Node;

interface IBase
{
    public function getTree($thumb);
    public function getThumb(Node $root);
}