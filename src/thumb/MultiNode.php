<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/8
 * Time: 21:52
 */

namespace flwt\thumb;


use flwt\wpd\Node;

class MultiNode extends Node
{

    /**
     * @var Node
     */
    protected $element;
    protected $num;

    /**
     * MultiNode constructor.
     * @param $element
     * @param $num
     */
    public function __construct($element, $num)
    {
        $this->element = $element;
        $this->num = $num;
    }

    public function showTree($step = 0, $delimit = "   ", $line = "\n")
    {
        for($i = 0; $i < $step; $i++)
            echo $delimit;
        echo '[multi_node:'. $this->num.']';
        $this->element->showTree(0, $delimit, $line);
        $gen = $this->getIterator();
        foreach ($gen as $element)
            $element->showTree($step + 1, $delimit, $line);
    }


}