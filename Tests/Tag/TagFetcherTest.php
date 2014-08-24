<?php

namespace Egulias\TagDebug\Tests\Tag;

use Egulias\TagDebug\Tag\Filter\AttributeValue;
use Egulias\TagDebug\Tag\Filter\Name;
use Egulias\TagDebug\Tag\FilterList;
use Egulias\TagDebug\Tag\TagFetcher;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TagFetcherTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchTagsWithNoFilters()
    {
        $container = new ContainerBuilder();
        $definition = $container->register('dummy_service', 'Egulias\Tests\ServiceDummy');
        $definition
            ->addTag('custom_tag_name', array('method' => 'name', 'number' => 8, 'another' => 'attribute'))
            ->setPublic(true);

        $fetcher = new TagFetcher($container);

        $filters = new FilterList(array());
        $services = $fetcher->fetch($filters);

        $this->assertCount(1, $services);
        $this->assertArrayHasKey('custom_tag_name', $services);
        $this->assertArrayHasKey('Egulias\Tests\ServiceDummy', $services['custom_tag_name']);
        $this->assertArrayHasKey('tag', $services['custom_tag_name']['Egulias\Tests\ServiceDummy']);
        //tag instance of tag
        $this->assertArrayHasKey('definition', $services['custom_tag_name']['Egulias\Tests\ServiceDummy']);
    }

    public function testFetchTagsFilteredWithOneFilter()
    {
        $container = new ContainerBuilder();
        $definition = $container->register('dummy_service', 'Egulias\Tests\ServiceDummy');
        $definition
            ->addTag('custom_tag_name', array('method' => 'name', 'number' => 8, 'another' => 'attribute'))
            ->setPublic(true);
        $definition2 = $container->register('another_dummy_service', 'Egulias\Tests\Service2Dummy');
        $definition2
            ->addTag('custom_tag_name', array('method' => 'name', 'number' => 8, 'another' => 'attribute'))
            ->setPublic(true);

        $fetcher = new TagFetcher($container);

        $filters = new FilterList();
        $filters->append(new Name('custom_tag_name'));
        $tags = $fetcher->fetch($filters);

        $this->assertCount(1, $tags);
        $this->assertCount(2, $tags['custom_tag_name']);
    }

    public function testFetchTagsFilteredWithMany()
    {
        $container = new ContainerBuilder();
        $definition1 = $container->register('dummy_service', 'Egulias\Tests\ServiceDummy');
        $definition1
            ->addTag('custom_tag_name', array('method' => 'name', 'number' => 8, 'another' => 'attribute'))
            ->setPublic(true);
        $definition2 = $container->register('another_dummy_service', 'Egulias\Tests\Service2Dummy');
        $definition2
            ->addTag('custom_tag_name', array('method' => 'name', 'number' => 10, 'another' => 'attribute'))
            ->setPublic(true);

        $fetcher = new TagFetcher($container);

        $filters = new FilterList();
        $filters->append(new Name('custom_tag_name'));
        $filters->append(new AttributeValue('number', 8));
        $tags = $fetcher->fetch($filters);

        $this->assertCount(1, $tags);
        $this->assertCount(1, $tags['custom_tag_name']);
    }
}
