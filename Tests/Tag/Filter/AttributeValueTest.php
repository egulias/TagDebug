<?php

namespace Egulias\TagDebug\Tests\Tag\Filter;

use Egulias\TagDebug\Tag\Filter;
use Egulias\TagDebug\Tag\Tag;

class AttributeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterByAGivenAttribute()
    {
        $attributeName = 'test';
        $string = 'value';
        $tag = new Tag('dummy_tag', array($attributeName => 'value'));
        $filter = new Filter\AttributeValue($attributeName, $string);
        $this->assertTrue($filter->isValid($tag));
    }

    public function testFilterByNotExistentAttribute()
    {
        $attributeName = 'test';
        $string = 'value';
        $tag = new Tag('dummy_tag', array($attributeName => 'value'));
        $filter = new Filter\AttributeValue($attributeName, 'not-exists');
        $this->assertFalse($filter->isValid($tag));
    }
}