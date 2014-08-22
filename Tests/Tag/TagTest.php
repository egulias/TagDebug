<?php

namespace Egulias\TagDebug\Tests\Tag;

use Egulias\TagDebug\Tag\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateTagWithNoAttributes()
    {
        $tag = new Tag('aTag', array());

        $this->assertEquals('aTag', $tag->getName());
    }

    public function testTagAttributeExists()
    {
        $tag = new Tag('aTag', array('attr1' => 'value'));

        $this->assertTrue($tag->hasAttribute('attr1'));
    }

    public function testGetTagAttribute()
    {
        $tag = new Tag('aTag', array('attr1' => 'value'));

        $this->assertEquals('value', $tag->get('attr1'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetTagArgumentNotExistsThrowsException()
    {
        $tag = new Tag('aTag', array('attr1' => 'value'));

        $tag->get('not-exists');
    }
}