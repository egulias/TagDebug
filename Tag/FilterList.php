<?php

namespace Egulias\TagDebug\Tag;

use \ArrayIterator;
use \InvalidArgumentException;
use Egulias\TagDebug\Tag\Filter;

class FilterList extends ArrayIterator
{
    public function __construct(array $filters = array(), $flags = 0)
    {
        $this->validateFilters($filters);
        parent::__construct($filters, $flags);
    }

    public function append($value)
    {
        $this->isFilter($value);
        parent::append($value);
    }

    private function validateFilters(array $filters)
    {
        array_filter($filters, $this->getValidationClosure());
    }

    private function getValidationClosure()
    {
        return function($filter) {
            $this->isFilter($filter);
        };
    }

    private function isFilter($filter)
    {
        if (!$filter instanceof Filter) {
            throw new InvalidArgumentException;
        }

        return true;
    }
}