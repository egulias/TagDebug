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

    public function fetch($showPrivate = false)
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
                $this->tags[$key][$definition->getClass()]['attributes'] = $attributes;
                $this->tags[$key][$definition->getClass()]['definition'] = $definition;
            }
        }

        return $this->tags;
    }
}
