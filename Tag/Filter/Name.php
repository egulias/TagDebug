<?php

namespace Egulias\TagDebug\Tag\Filter;

use Egulias\TagDebug\Tag\Tag;

class Name extends Filter
{
    public function isValid(Tag $tag)
    {
        return $this->expectedValue === $tag->getName();
    }
}