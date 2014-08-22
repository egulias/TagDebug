<?php

namespace Egulias\TagDebug\Tag\Filter;

use Egulias\TagDebug\Tag\Filter as FilterInterface;

abstract class Filter implements FilterInterface
{
    protected $expectedValue;

    public function __construct($expectedValue)
    {
        $this->expectedValue = $expectedValue;
    }
}