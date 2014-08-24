<?php

namespace Egulias\TagDebug\Tag;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Definition;

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
            if ($this->showOnyPublic($definition, $showPrivate)) {
                continue;
            }

            if ($definition instanceof Alias) {
                continue;
            }

            $this->fetchTags($definition, $filters);
        }

        return $this->tags;
    }

    private function showOnyPublic(Definition $definition, $showPrivate = false)
    {
        if ($showPrivate && !$definition->isPublic()) {
            return true;
        }

        return false;
    }

    private function fetchTags(Definition $definition, FilterList $filters)
    {
        $tags = $definition->getTags();
        if (empty($tags)) {
            return;
        }

        foreach ($tags as $key => $attributes) {
            $tag = new Tag($key, $attributes[0]);
            if ($this->filter($tag, $filters)) {
                $this->tags[$key][$definition->getClass()]['tag'] = $tag;
                $this->tags[$key][$definition->getClass()]['definition'] = $definition;
            }
        }
    }

    private function filter(Tag $tag, FilterList $filters)
    {
        foreach ($filters as $filter) {
            if (!$filter->isValid($tag)) {
                return false;
            }
        }

        return true;
    }
}
