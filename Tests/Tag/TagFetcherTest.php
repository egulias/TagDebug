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
        $this->assertInstanceOf('Egulias\TagDebug\Tag\Tag', $services['custom_tag_name']['dummy_service']);
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

    public function testFetchTagsDefinitionHasNoTags()
    {
        $container = new ContainerBuilder();
        $container->register('dummy_service', 'Egulias\Tests\ServiceDummy');

        $fetcher = new TagFetcher($container);

        $filters = new FilterList();
        $filters->append(new Name('custom_tag_name'));
        $tags = $fetcher->fetch($filters);

        $this->assertCount(0, $tags);
    }

    public function testFetchTagsFromPublicDefinitionsOnly()
    {
        $container = new ContainerBuilder();
        $definition1 = $container->register('dummy_service', 'Egulias\Tests\ServiceDummy');
        $definition1
            ->addTag('custom_tag_name', array('method' => 'name', 'number' => 8, 'another' => 'attribute'))
            ->setPublic(true);
        $definition2 = $container->register('another_dummy_service', 'Egulias\Tests\Service2Dummy');
        $definition2
            ->addTag('custom_tag_name', array('method' => 'name', 'number' => 10, 'another' => 'attribute'))
            ->setPublic(false);

        $fetcher = new TagFetcher($container);

        $filters = new FilterList();
        $filters->append(new Name('custom_tag_name'));
        $tags = $fetcher->fetch($filters);

        $this->assertCount(1, $tags);
        $this->assertCount(1, $tags['custom_tag_name']);
    }

    public function testFetchTagsDefinitionIsAlias()
    {
        $container = new ContainerBuilder();
        $definition1 = $container->register('dummy_service', 'Egulias\Tests\ServiceDummy');
        $definition1
            ->addTag('custom_tag_name', array('method' => 'name', 'number' => 8, 'another' => 'attribute'))
            ->setPublic(true);
        $container->setAlias('alias_service', 'dummy_service');
        $fetcher = new TagFetcher($container);

        $filters = new FilterList();
        $filters->append(new Name('custom_tag_name'));
        $tags = $fetcher->fetch($filters);

        $this->assertCount(1, $tags);
        $this->assertCount(1, $tags['custom_tag_name']);
    }
}
