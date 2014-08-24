<?php

namespace Egulias\TagDebug\Tag\Filter;

use Egulias\TagDebug\Tag\Tag;

class NameRegEx extends Filter
{
    protected $attributeName;

    public function __construct($attrName, $expectedValue)
    {
        $this->attributeName = $attrName;
        $regex = $this->createRegEx($expectedValue);
        parent::__construct($regex);
    }

    public function isValid(Tag $tag)
    {
        if (!$tag->hasAttribute($this->attributeName)) {
            return false;
        }

        $value = $tag->get($this->attributeName);

        return  (bool) preg_match($this->expectedValue, $value);
    }


    private function createRegEx($string)
    {
        return '~' . $string . '~i';
    }
}