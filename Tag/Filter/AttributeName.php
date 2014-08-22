<?php

namespace Egulias\TagDebug\Tag\Filter;

use Egulias\TagDebug\Tag\Tag;

class AttributeName extends Filter
{
    public function isValid(Tag $tag)
    {
        if ($tag->hasAttribute($this->expectedValue)) {
            return true;
        }

        return false;
    }
}