<?php
/**
 * User: ZZCTMAC
 * Date: 2017/2/4
 * Time: 20:55
 */

namespace flwt\wpd;




use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use flwt\lib\Common;
use flwt\thumb\MultiNode;
use flwt\thumb\xpath\Impl;
use flwt\wpd\search\XPath;

abstract class Node implements \IteratorAggregate
{
    
    protected $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    
    
    /**
     * @var array
     */
    protected $attrs = [];

    /**
     * @var string
     */
    protected $text = '';

    
    protected $elements = array();
    
    protected $blur = false;

    
    
    public function getElementCount()
    {
        return count($this->elements);
    }

    public function addElement(Node $element)
    {
        $this->elements[] = $element;
        return $this;
    }

    /**
     * @var WebDriverElement
     */
    protected $driverElement;
    
    

    public function removeElement(Node $element)
    {
        $keys = array();
        foreach ($this->elements as $key=>$originElement)
        {
            if($originElement === $element)
                $keys[] = $key;
        }

        foreach ($keys as $key)
        {
            unset($this->elements[$key]);
        }
        return $this;
    }

    public function setAttr($name, $value)
    {
        static $singleAttr = array('id', 'value');
        if(in_array($name, $singleAttr))
            return $this->setSingleAttr($name, $value);
        if(!isset($this->attrs[$name]))
        {
            $this->attrs[$name] = $value;
            return $this;
        }
        if(isset($this->attrs[$name]) &&  !is_array($this->attrs[$name]))
        {
            $this->attrs[$name] = array($this->attrs[$name]);

        }
        $this->attrs[$name][] = $value;
        return $this;
    }

    public function setSingleAttr($name, $value)
    {
        $this->attrs[$name] = $value;
        return $this;
    }
    
    public function getAttrs()
    {
        return $this->attrs;
    }

    public function getAttr($name)
    {
        if( $this->driverElement !== null )
        {
            return $this->driverElement->getAttribute($name);
        }
        return isset($this->attrs[$name]) ? $this->attrs[$name] : null; 
    }
    
    public function unsetAttr($name)
    {
        unset($this->attrs[$name]);
        return $this;
    }

    public function getId()
    {
        $id =  $this->getAttr('id');
        if($id == "")
            $id = null;
        return $id;
    }

    public function setId($value)
    {
        return $this->setSingleAttr('id', $value);
    }

    public function getValue()
    {
        return $this->getAttr('value');
    }

    public function setValue($value)
    {
        if($this->driverElement !== null)
        {
            $this->driverElement->sendKeys($value);
        }
        return $this->setSingleAttr('value', $value);
    }
    
    public function input($value)
    {
        return $this->setValue($value);
    }
    
    public function hasAttr($name)
    {
        return  $this->driverElement !== null ? $this->driverElement->getAttribute($name) !== null : isset($this->attrs[$name]);
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    
    public function getText($cache = 0)
    {
        if($this->driverElement !== null && $cache == 0)
        {
            $text =  $this->driverElement->getText();
            $this->setText($text);
        }
        return $this->text;
    }

    /**
     * @param int $wait
     * @return nodes\Alert|Page|null
     */
    public function click($wait = 0)
    {
        if( $this->driverElement !== null )
        {
            $this->driverElement->click();
        }
        return self::clickResp($wait);
    }


    //TODO: wait for more event
    /**
     * @param int $wait
     * @return nodes\Alert|Page|null
     */
    protected  static function clickResp($wait = 0)
    {
        $page = PageContainer::top();
        if($wait)
            $alert = $page->getAlert($wait);
        else
            $alert = null;
        if($alert != null)
        {
            $alert->setClickCallback(function(){
               PageContainer::tryRedirect();
            });
            return $alert;
        }

        PageContainer::tryRedirect();
        return PageContainer::top();
    }

    /**
     * @param int $wait
     * @return nodes\Alert|Page|null
     */
    public function submit($wait = 0)
    {
        if( $this->driverElement !== null )
        {
            $this->driverElement->submit();
        }
       return self::clickResp($wait);
    }

    
    public function isDisPlayed()
    {
        if( $this->driverElement !== null )
        {
            return $this->driverElement->isDisplayed();
        }
        return false;
    }

    public function isEnabled()
    {
        if( $this->driverElement !== null )
        {
            return $this->driverElement->isEnabled();
        }
        return false;
    }

    public function isSelected()
    {
        if( $this->driverElement !== null )
        {
            return $this->driverElement->isSelected();
        }
        return false;
    }
    
    protected static function getElementsByAttrRecursion(&$elements, Node $root, $name, $value)
    {
        $gen = $root->getIterator();
        foreach ($gen as $element)
        {
            $originValue = $element->getAttr($name);
            if((is_array($originValue) && in_array($value, $originValue, true)) || $originValue === $value)
                $elements[] = $element;
            static::getElementsByAttrRecursion($elements, $element, $name, $value);
        }
    }

    private static function getElementsByTagNameRecursion(&$elements, Node $root, $name)
    {
        $gen = $root->getIterator();
        foreach ($gen as $element)
        {
            $originValue = $element->getName();
            if($originValue === $name)
                $elements[] = $element;
            static::getElementsByTagNameRecursion($elements, $element, $name);
        }
    }

    /**
     * @param $name
     * @param $value
     * @return Elements
     */
    public function getElementsByAttr($name, $value)
    {
        static::getElementsByAttrRecursion($elements, $this, $name, $value);
        $elements = new Elements($elements);
        return $elements;
    }
    
    public function getElementsByTagName($name)
    {
        static::getElementsByTagNameRecursion($elements, $this, $name);
        $elements = new Elements($elements);
        return $elements;
    }
    
    public function getElementsByClass($value)
    {
        return $this->getElementsByAttr('class', $value);
    }

    /**
     * @param $value
     * @return Node|null
     */
    public function getElementById($value)
    {
        $gen = $this->getIterator();
        foreach ($gen as $element)
        {
            if($element->getId() === $value)
            {
                return $element;
            } else {
                $res = $element->getElementById($value);
                if($res != null)
                    return $res;
            }
        }
        return null;
    }

    /**
     * @return Node[]
     */
    public function getIterator()
    {
        foreach ($this->elements as $element)
            yield $element;
    }
    
    public function showTree($step = 0, $delimit = "   ", $line = "\n")
    {
        for($i = 0; $i < $step; $i++)
            echo $delimit;
        echo $this->name . $this->getAttrString(). $line;
        $gen = $this->getIterator();
        foreach ($gen as $element)
            $element->showTree($step + 1, $delimit, $line);
    }
    
    private function getAttrString()
    {
        $arr = array();
        foreach ($this->attrs as $k=>$v)
        {
            if(is_array($v))
            {
                $v = implode(' ', $v);
            }
            $arr[] = $k.'="'.$v . '"';
            
        }
        if(count($arr) > 0)
        {
            return '[' . implode(',', $arr) . ']';
        }
        return '';
    }



    use XPath;

    public static function loadInfoFromDriver(Node $node, WebDriver $driver)
    {
        do
        {
            $id = $node->getId();
            if($id !== null)
            {
                $element = $driver->findElement(WebDriverBy::id($id));
                $node->setBlur(true);
                break;
            }
            
            $xpath = $node->getXpath();
            
            if($node instanceof MultiNode)
            {
                $elements = $driver->findElements(WebDriverBy::xpath($xpath));
                $elemCount = count($elements);
                $realNum = $node->getRealNum();
                $realNum = !is_numeric($realNum) ? $elemCount : intval($realNum);
                $realNum = min($realNum, $elemCount);
                $parent = $node->getParent();
                $parent->removeElement($node);
                $realNode = $node->getRealNode();
                for($i = 0; $i < $realNum; $i++)
                {
                    $tmpNode = clone  $realNode;
                    $tmpNode->setDriverElement($elements[$i]);
                    $pgen = $node->getIterator();
                    $tmpNode->setMultiIndex($i);
                    foreach ($pgen as $pnode)
                    {
                        $tmpNode->addElement(clone $pnode);
                    }
                    $parent->addElement($tmpNode);
                    $pgen = $tmpNode->getIterator();
                    foreach ($pgen as $pnode)
                    {
                        self::loadInfoFromDriver($pnode, $driver);
                    }
                }
                
                return ;


                break;
            }
            
            try {
                $element = $driver->findElement(WebDriverBy::xpath($xpath));
            }
            catch (NoSuchElementException $e)
            {
                $xpath = Impl::getBlurXpath($xpath);
                $element = $driver->findElement(WebDriverBy::xpath($xpath));
                $node->setBlur(true);
            }
            
                
            
        }while(false);
        if(isset($element) && $element !== null)
        {
            $node->setDriverElement($element);
        }
        
        $gen = $node->getIterator();
        foreach ($gen as  $k=>$element)
        {
            self::loadInfoFromDriver($element, $driver);
        }
    }

    /**
     * @param mixed $driverElement
     */
    public function setDriverElement($driverElement)
    {
        $this->driverElement = $driverElement;
    }

    /**
     * @return boolean
     */
    public function isBlur()
    {
        return $this->blur;
    }

    /**
     * @param boolean $blur
     */
    public function setBlur($blur)
    {
        $this->blur = $blur;
    }

    protected $uselessForTwinAttrs = array();
    
    public function isSame(Node $node)
    {
        $nid = $node->getId();
        $tid = $this->getId();
        if($tid !== null && $nid === $tid)
        {
            return true;
        }
        $checkOnlyName = array('html', 'head', 'title', 'body');
        $nname = strtolower($node->getName());
        $tname = strtolower($this->getName());
        do
        {
            if($nname !== $tname)
                return false;

            if(in_array($nname, $checkOnlyName))
            {
                return true;
            }
        }while(false);
        return Common::arraySame($this->getAttrs(), $node->getAttrs());

    }

    public function isTwin(Node $node, $checkText = false)
    {
        if($node->getName() != $this->getName())
            return false;

        foreach ($this->attrs as $k=>$attr)
        {
            if(in_array($k, $this->uselessForTwinAttrs))
                continue;
            if($attr == null)
                continue;
            $nodeAttr = $node->getAttr($k);
            if(is_array($attr) && is_array($nodeAttr))
            {
                if(count(array_diff($attr, $nodeAttr)) == 0)
                {
                    continue;
                }
                else
                {
                    return false;
                }
            }
            elseif(!is_array($attr) && $attr == $nodeAttr)
            {
                continue;
            }
            else
            {
                return false;
            }
        }

        if($checkText)
        {
            $text =  $this->getText();
            if($text != null)
            {
                if($text != $node->getText())
                    return false;
            }
        }
        return true;

    }
    
    public function getTwinNumber(Node $son, &$index = null)
    {
        $num = 0;
        $index = 0;
        if($son->getId() != null)
        {
            return 0;
        }


        $gen = $this->getIterator();
        $isSon = false;
        foreach ($gen as $node)
        {
            if($node === $son)
            {
                $index = $num;
                $isSon = true;
                continue;
            }
            if($son->isTwin($node))
            {
                $num++;
            }
        }
        return $isSon ? $num : 0;
    }

    /**
     * @var Node
     */
    protected $parent;
    public function setParent($root)
    {
        $this->parent = $root;
    }
    
    public function getParent()
    {
        return $this->parent;
    }

    public function getParentIndex()
    {
        if($this->parent == null)
        {
            return -1;
        }
        $gen = $this->parent->getIterator();
        foreach ($gen as $index=>$node)
        {
            if($node === $this)
                return $index;
        }

        return -1;
    }

    public function __clone() {
        foreach ($this->elements as &$a) {
            $a = clone $a;
        }
    }

    protected $multiIndex = null;
    public function getIndexByMulti()
    {
        return $this->multiIndex;
    }

    /**
     * @param null $multiIndex
     */
    public function setMultiIndex($multiIndex)
    {
        $this->multiIndex = $multiIndex;
    }

    public function clear()
    {
        $this->driverElement = null;
        $gen = $this->getIterator();
        foreach ($gen as $item)
        {
            $item->clear();
        }
    }

}