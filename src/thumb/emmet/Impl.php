<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/7
 * Time: 22:02
 */

namespace flwt\thumb\emmet;

use flwt\thumb\IBase;
use flwt\thumb\NodeCreator;
use flwt\thumb\Root;
use flwt\thumb\StringTraversal;
use flwt\wpd\Node;

class Impl implements IBase
{

    
    
    
    protected $suffix = "html>(head>title)+body";
    
    const INVALID_TIP = "this emmet is not valid";

    /**
     * @param string $suffix
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }



    use NodeCreator;
    use StringTraversal;

    /**
     * @param $root Node|null
     * @param $tmp
     * @return Node|null
     */
    protected static function addToRoot(&$root, &$tmp)
    {
        $tmpLen = strlen($tmp);
        if ($tmp[0] == '(' && $tmp[$tmpLen - 1] == ')') {
            $tmpNode = self::parseThumb($root, substr($tmp, 1, $tmpLen - 2));
        } else {
            $tmpNode = self::createNode(self::parseNodeInfo($tmp));
            $root->addElement($tmpNode);
        }
        
        $tmp = '';
        return $tmpNode;
    }

    /**
     * @param $root
     * @param $thumb
     * @return Node|null
     * @throws \Exception
     */
    public static function parseThumb(&$root, $thumb)
    {
        $tmp = '';
        $gen = self::getStringIterator($thumb);
        $bracketStack = new \SplStack();
        $parent = &$root;
        foreach ($gen as $k=>$ch)
        {
            if($ch === '>') {
                do 
                {
                    if (!$bracketStack->isEmpty()) {
                        $tmp .= $ch;
                        break;
                    }
                    $res = self::addToRoot($parent, $tmp);
                    unset($parent);
                    $parent = &$res;
                }while(0);
            }
            elseif($ch === '+')
            {
                do
                {
                    if (!$bracketStack->isEmpty()) {
                        $tmp .= $ch;
                        break;
                    }
                    self::addToRoot($parent, $tmp);
                    
                }while(0);
            }
            else {
                $tmp .= $ch;
                if($ch === '(')
                {
                    $bracketStack->push(1);
                }
                elseif($ch === ')')
                {
                    $bracketStack->pop();
                }
            }
        }
        if(!$bracketStack->isEmpty())
        {
            throw new \Exception(self::INVALID_TIP);
        }
        if($tmp != "")
            self::addToRoot($parent, $tmp);

        return $root;
    }

    protected static function handleEmmetNodeDelimit($handle, $string)
    {
        $res = array('attr'=>array());
        static $easyHandle = array('#'=>'id', '.'=>'class');
        do
        {
            if($handle == null)
            {
                $res['name'] = $string;
                break;
            }

            if(array_key_exists($handle, $easyHandle))
            {
                $res['attr'][$easyHandle[$handle]] = $string;
                break;
            }
            if($handle == '[')
            {
                $string = substr($string, 0, strlen($string) - 1);
                $stringArr = explode('=', $string);
                $res['attr'][$stringArr[0]] = $stringArr[1];
                break;
            }

            if($handle == '*')
            {
                if(is_numeric($string))
                {
                    $string = intval($string);
                }
                $res['number'] = $string;
            }

        }while(false);
        return $res;
    }

    public static function parseNodeInfo($thumb)
    {
        $res = array();

        static $delimitArr = array('#', '.', '[', '*');
        $gen = self::getStringIterator($thumb);

        $tmp = '';
        $handle = null;
        foreach ($gen as $index=>$ch)
        {
            if(in_array($ch, $delimitArr))
            {
                $res = array_merge_recursive($res, self::handleEmmetNodeDelimit($handle, $tmp));
                $handle = $ch;
                $tmp = '';
            }
            else
            {
                $tmp .= $ch;
            }
        }

        $res = array_merge_recursive($res, self::handleEmmetNodeDelimit($handle, $tmp));
        return $res;
    }

    /**
     * @param $thumb
     * @return Node|null
     * @throws \Exception
     */
    public function getTree($thumb)
    {
        do {
            if($thumb == "")
            {
                $thumb = $this->suffix;
                break;
            }

            if ($this->suffix != "")
            {
                $thumb = sprintf($this->suffix . ">%s", $thumb);
                break;
            }
        }while(0);
        $root = new Root();
        self::parseThumb($root, $thumb);
        return $root->getSon();

    }

    public function getThumb(Node $root)
    {
        // TODO: Implement getThumb() method.
    }
}