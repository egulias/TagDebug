<?php

namespace Egulias\TagDebug\Tag\Filter;

use Egulias\TagDebug\Tag\Tag;

class AttributeValue extends Filter
{
    protected $attributeName;

    public function __construct($attrName, $expectedValue)
    {
        $this->attributeName = $attrName;
        parent::__construct($expectedValue);
    }

    public function isValid(Tag $tag)
    {
        if (!$tag->hasAttribute($this->attributeName)) {
            return false;
        }

        return $tag->get($this->attributeName) === $this->expectedValue;
    }
}