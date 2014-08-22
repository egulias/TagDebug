<?php

namespace Egulias\TagDebug\Tests\Tag\Filter;

use Egulias\TagDebug\Tag\Filter\Name;
use Egulias\TagDebug\Tag\Tag;

class NameTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterSimpleStringIsValid()
    {
        $string = 'dummy_tag';
        $tag = new Tag('dummy_tag', array());
        $filter = new Name($string);
        $this->assertTrue($filter->isValid($tag));
    }

    public function testFilterSimpleStringIsInvalid()
    {
        $string = 'dummy_tag';
        $tag = new Tag('not_dummy_tag', array());
        $filter = new Name($string);
        $this->assertFalse($filter->isValid($tag));
    }
}