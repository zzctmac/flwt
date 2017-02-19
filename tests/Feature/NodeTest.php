<?php

/**
 * User: ZZCTMAC
 * Date: 2017/2/4
 * Time: 20:57
 */
class NodeTest extends PHPUnit_Framework_TestCase
{
    public function test_link_node_attr_set()
    {
        //arrange
        $node = new flwt\wpd\nodes\Link();
        $url = "http://baidu.com";
        $target = '_blank';
        //act
        $node->setAttr('href', $url);
        $node->setAttr('target', $target);

        //assert
        $this->assertEquals($node->getAttr('href'), $url);
        $this->assertTrue($node->hasAttr('target'));
        $this->assertFalse($node->hasAttr('foo'));
    }

    public function test_link_node_text()
    {
        //arrange
        $node = new \flwt\wpd\nodes\Link();

        //act
        $node->setText('query');

        //asset
        $this->assertEquals($node->getText(), 'query');
    }

    public function test_input_value()
    {

        $node = new \flwt\wpd\nodes\Link();
        $name = 'zzc';
        
        $node->setValue($name);

        $this->assertEquals($node->getValue(), $name);
    }

    public function test_find_element_by_attr()
    {
        $node = new \flwt\wpd\nodes\Link();
        $son = new \flwt\wpd\nodes\Link();
        $son->setAttr('id', 'name')->setAttr('class', 'c');
        $node->addElement($son);


        $elements = $node->getElementsByAttr('class', 'c');
        $son = $elements->getElementByIndex(0);
        $this->assertEquals($son->getId(), 'name');
    }

    public function test_find_element_by_id()
    {
        $node = new \flwt\wpd\nodes\Html();
        $son = new \flwt\wpd\nodes\Link();
        $son->setId('name');
        $node->addElement($son);
        $n = $node->getElementById('name');
        $this->assertTrue($son === $n);
    }
}
