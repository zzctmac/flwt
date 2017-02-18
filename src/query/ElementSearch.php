<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/18
 * Time: 13:12
 */

namespace flwt\query;


use flwt\wpd\Elements;
use flwt\wpd\Node;
use flwt\wpd\PageContainer;

trait ElementSearch
{
    /**
     * @param Node $tree
     * @return Elements
     */
    public static function getElementsByHtmlTree(Node $tree)
    {
        $elements = array();
        $page = PageContainer::top();
        $root = $page->getHtmlTree();
        self::getElementsByHtmlTreeRec($root, $tree, $elements);
        return new Elements($elements);
    }

    protected static function getElementsByHtmlTreeRec(Node $originTree, Node $tree, &$elements)
    {
        if($originTree == null)
        {
            return ;
        }
        if(!$tree->isSame($originTree))
        {
            $gen = $originTree->getIterator();
            foreach ($gen as $son)
            {
                self::getElementsByHtmlTreeRec($son, $tree, $elements);
            }
            return ;
        }
        $treeSonCount = $tree->getElementCount();
        if($treeSonCount == 0)
        {
            $elements[] = $originTree;
            return ;
        }
        $og = $originTree->getIterator();
        foreach ($og as $os)
        {
            $tg = $tree->getIterator();
            foreach ($tg as $ts)
            {
                self::getElementsByHtmlTreeRec($os, $ts, $elements);
            }
        }
    }
        
}