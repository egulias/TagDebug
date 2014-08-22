<?php

namespace Egulias\TagDebug\Tag;

interface Filter
{
    public function isValid(Tag $tag);
}