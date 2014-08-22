<?php

namespace Egulias\TagDebug\Tests\Tag\Filter;

use Egulias\TagDebug\Tag\Filter;
use Egulias\TagDebug\Tag\Tag;

class AttributeNameTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterByExistentAttributeName()
    {
        $attributeName = 'test';
        $tag = new Tag('dummy_tag', array($attributeName => 'value'));
        $filter = new Filter\AttributeName($attributeName);
        $this->assertTrue($filter->isValid($tag));
    }

    public function testFilterByNotExistentAttributeName()
    {
        $attributeName = 'test';
        $tag = new Tag('dummy_tag', array($attributeName => 'value'));
        $filter = new Filter\AttributeName('not-exists');
        $this->assertFalse($filter->isValid($tag));
    }
}