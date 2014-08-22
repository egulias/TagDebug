<?php

namespace Egulias\TagDebug\Tag;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Alias;

class TagFetcher
{
    protected $tags = array();
    protected $builder;

    public function __construct(ContainerBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function fetch(FilterList $filters, $showPrivate = false)
    {
        $definitions = $this->builder->getDefinitions();

        foreach ($definitions as $definition) {
            if (!$showPrivate && !$definition->isPublic()) {
                continue;
            }

            if ($definition instanceof Alias) {
                continue;
            }

            $tags = $definition->getTags();
            if (empty($tags)) {
                continue;
            }
            foreach ($tags as $key => $attributes) {
                $tag = new Tag($key, $attributes);
                if ($this->applyFilters($tag, $filters)) {
                    $this->tags[$key][$definition->getClass()]['tag'] = $tag;
                    $this->tags[$key][$definition->getClass()]['definition'] = $definition;
                }
            }
        }

        return $this->tags;
    }

    private function applyFilters(Tag $tag, FilterList $filters)
    {
        foreach ($filters as $filter) {
            if (!$filter->isValid($tag)) {
                return false;
            }
        }

        return true;
    }
}
