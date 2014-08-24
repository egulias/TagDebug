<?php

namespace Egulias\TagDebug\Tag;

class Tag
{

    protected $attributes = array();
    protected $name;

    public function __construct($name, array $attributes = array())
    {
        $this->attributes = $attributes;
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function hasAttribute($attrName)
    {
        return isset($this->attributes[$attrName]);
    }

    public function get($attrName)
    {
        if ($this->hasAttribute($attrName)) {
            return $this->attributes[$attrName];
        }

        throw new \InvalidArgumentException(sprintf('Tag %s has no %s attribute', $this->getName(), $attrName));
    }
}