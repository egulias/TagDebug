# Tag debug for Symfony2 DIC Events

This library will fetch information about all the tagged services

# Installation and configuration

## Get the lib
php composer.phar require egulias/tags-debug

## Use
Basic usage
-----------

```php
<?php

use Egulias\TagDebug\Tag\TagFetcher;
use Egulias\TagDebug\Tag\FilterList;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$fetcher = new TagFetcher($containerBuilder);

$filters = new FilterList();
$tags = $fetcher->fetch($filters);
```

Filtering
-----------
Currently filters work in an "AND" fashion, which means that the Tag must comply every filter.

```php
<?php

use Egulias\TagDebug\Tag\TagFetcher;
use Egulias\TagDebug\Tag\FilterList;
use Egulias\TagDebug\Tag\Filter\Name;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$fetcher = new TagFetcher($containerBuilder);

$filters = new FilterList();
$filters->addFilter(new Name("nameToFilterFor"));
$tags = $fetcher->fetch($filters);
```

You can implement your own filters by implementing `Egulias\TagDebug\Tag\Filter` and then adding it to the filter list.

