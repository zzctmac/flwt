<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/13
 * Time: 22:22
 */

namespace flwt\thumb\xpath;


use flwt\thumb\IBase;
use flwt\thumb\MultiNode;
use flwt\wpd\Node;

class Impl implements IBase
{

    public function getTree($thumb)
    {
        // TODO: Implement getTree() method.
    }

    public function getThumb(Node $root, Node $child = null, $step = 0)
    {
        $thumb = self::getSingleThumb($root);
        $multiIndex = $root->getIndexByMulti();
        if($multiIndex !== null)
        {
            $thumb .= '[' . ($multiIndex + 1) . ']';
        }
        if($step == 0)
        {
            $thumb = '/' . $thumb;
        }
        if($root === $child)
        {
            if($root instanceof MultiNode)
            {
                $multiNode = $root;
                $root = $multiNode->getRealNode();
                $thumb = self::getSingleThumb($root);
            }
            else
            {
                $twinNumber = $root->getTwinNumber($child, $twinIndex);
                if ($twinNumber > 0 )
                {
                    $thumb .= '[' . ($twinIndex + 1) . ']';
                }
            }
            return  $thumb;
        }

        $count = $root->getElementCount();
        if($count == 0)
        {
            return null;
        }
        else
        {
            $gen = $root->getIterator();

            foreach ($gen as $element)
            {
                $element->setParent($root);
                $tmp = static::getThumb($element, $child, $step + 1);
                if($tmp !== null)
                {
                    $delimit = $element->isBlur() ? "//" : "/";
                    return $thumb . $delimit . $tmp;

                }
            }
            
            return null;
        }

    }

    protected static function getSingleThumb(Node $node)
    {
        $thumb = $node->getName();
        $attrs = $node->getAttrs();
        $attrTemplate = "@%s='%s'";
        $attrThumb = array();
        foreach ($attrs as $name=>$value)
        {
            if(is_array($value))
            {
                $value = implode(' ', $value);
            }
            $tmp = sprintf($attrTemplate, $name, $value);
            $attrThumb[] = $tmp;
        }
        if(!empty($attrThumb))
        {
            return $thumb . '[' . implode(' and ', $attrThumb) . ']';
        }
        return $thumb;

    }

    public static function getBlurXpath($str)
    {
        $pos = strrpos($str, "/");

        $replace = "/" .  substr($str, $pos);

        return  substr_replace($str, $replace, $pos);
    }
}