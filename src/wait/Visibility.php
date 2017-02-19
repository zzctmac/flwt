<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/19
 * Time: 17:28
 */

namespace flwt\wait;


use Facebook\WebDriver\Exception\TimeOutException;
use Facebook\WebDriver\WebDriverExpectedCondition;
use flwt\Resource;
use flwt\wpd\Node;

class Visibility extends Base
{

    /**
     * @var Node
     */
    protected $node;

    /**
     * Visibility constructor.
     * @param Node $node
     */
    public function __construct(Node $node)
    {
        $this->node = $node;
    }
    
    public static function create(Node $node)
    {
        return new static($node);
    }


    public function getRes($wait)
    {
        $element = $this->node->getDriverElement();
        $driver = Resource::getGlobalDriver();
        try {
            $res = $driver->wait($wait)->until(WebDriverExpectedCondition::visibilityOf($element));
            if($res !== null)
            {
                return $this->node;
            }
        } catch (TimeOutException $e)
        {
            return null;
        }
        
        return null;
        
    }
}