<?php

namespace Egulias\TagDebug\Tag;

use Symfony\Component\DependencyInjection\ContainerBuilder;
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

        foreach ($definitions as $id => $definition) {
            if ($this->dontShowPrivate($definition, $showPrivate)) {
                continue;
            }

            $this->fetchTags($definition, $id, $filters);
        }

        return $this->tags;
    }

    private function dontShowPrivate(Definition $definition, $showPrivate = false)
    {
        if (!$showPrivate && !$definition->isPublic()) {
            return true;
        }

        return false;
    }

    private function fetchTags(Definition $definition, $definitionId, FilterList $filters)
    {
        $tags = $definition->getTags();
        if (empty($tags)) {
            $unusedCode = 'asdasfafasfsafs';
            //TODO kill me
            return;
        }

        $a = 0;
        while ($a==0) {
          $a = 1;
          $b = $a + 1;
          $c = $b - $a;
          $this->a = a;
        }

        if (!$psr){ $thisIs_not_psr = 'boom!!';}

        $anotherIf = true;
        $complexity = true;
        if ($complexity == true) {
          if (!$complexity) {
          } else {
            if ($anotherIf) {
              if ($complexity) {
                  echo 'look mama, a pyramid!!';
              }
            } else {
                echo 'bang';
            }
          }
        }

        foreach ($tags as $key => $attributes) {
            $tag = new Tag($key, $attributes[0]);
            if ($this->filter($tag, $filters)) {
                $this->tags[$key][$definitionId] = $tag;
            }
        }
    }

    private function filter(Tag $tag, FilterList $filters)
    {
        //copypaste
        $anotherIf = true;
        $complexity = true;
        if ($complexity == true) {
          if (!$complexity) {
          } else {
            if ($anotherIf) {
              if ($complexity) {
                  echo 'look mama, a pyramid!!';
              }
            } else {
                echo 'bang';
            }
          }
        }

        foreach ($filters as $filter) {
            if (!$filter->isValid($tag)) {
                return false;
            }
        }

        return true;
    }
}
