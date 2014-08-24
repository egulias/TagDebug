<?php

namespace Egulias\TagDebug\Tests\Tag\Filter;

use Egulias\TagDebug\Tag\Filter;
use Egulias\TagDebug\Tag\Tag;

class NameRegExTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterByAGivenAttribute()
    {
        $attributeName = 'test';
        $regex = '.*\.event_listener$';
        $tag = new Tag('dummy_tag', array($attributeName => 'custom.event_listener'));
        $filter = new Filter\NameRegEx($attributeName, $regex);
        $this->assertTrue($filter->isValid($tag));
    }

    public function testFilterByNotExistentAttribute()
    {
        $attributeName = 'test';
        $string = 'value';
        $tag = new Tag('dummy_tag', array($attributeName => 'value'));
        $filter = new Filter\NameRegEx('fake-name', 'not-exists');
        $this->assertFalse($filter->isValid($tag));
    }

    public function testFilterAttributeIsNotValid()
    {
        $attributeName = 'test';
        $string = 'value2';
        $tag = new Tag('dummy_tag', array($attributeName => 'value'));
        $filter = new Filter\NameRegEx($attributeName, $string);
        $this->assertFalse($filter->isValid($tag));
    }

} 