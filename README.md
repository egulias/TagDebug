# Tag debug for Symfony2 DIC Events [![Build Status](https://travis-ci.org/egulias/TagDebug.svg?branch=1.0.0)](https://travis-ci.org/egulias/TagDebug) [![Coverage Status](https://coveralls.io/repos/egulias/TagDebug/badge.png)](https://coveralls.io/r/egulias/TagDebug) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/egulias/TagDebug/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/egulias/TagDebug/?branch=master)

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

`$tags` will have one key for each tag name:
 ```php
$tags['tag-name']['Class\Name\Of\Service']['tag'] = Egulias\TagDebug\Tag\Tag
$tags['tag-name']['Class\Name\Of\Service']['definition'] = Symfony\Component\DependencyInjection\Definition
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

