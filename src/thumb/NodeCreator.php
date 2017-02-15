<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/7
 * Time: 22:25
 */

namespace flwt\thumb;


use flwt\wpd\Node;
use flwt\wpd\nodes\Link;
use flwt\wpd\nodes\Normal;

trait NodeCreator
{
    /**
     * @param $name
     * @return mixed|null|string
     */
    protected static function getClass($name)
    {
        $name = strtolower($name);
        static $map = array(
            'a'=>Link::class
        );
        if(array_key_exists($name, $map))
        {
            return $map[$name];
        }
        $className = "flwt\\wpd\\nodes\\" . ucfirst($name);
        if(class_exists($className)) {
            return $className;
        }
        return null;
    }

    /**
     * @param $nodeInfo
     * @return Node
     */
    public static function createNode($nodeInfo)
    {
        $name = $nodeInfo['name'];
        $class = self::getClass($name);
        if($class === null) {
            $other = 1;
            $class = Normal::class;
        } else {
            $other = 0;
        }
        $node = new $class();
        if($other) $node->setName($name);
        foreach ($nodeInfo['attr']  as $k=>$v)
            $node->setAttr($k, $v);
        if(isset($nodeInfo['number']))
        {
            $node = new MultiNode($node, $nodeInfo['number']);
        }
        return $node;
    }
    
}