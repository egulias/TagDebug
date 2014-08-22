<?php

namespace Egulias\TagDebug\Tests\Tag;

use Egulias\TagDebug\Tag\TagFetcher;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * TagFetcherTest
 *
 * @author Eduardo Gulias Davis <me@egulias.com>
 */
class TagFetcherTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchTags()
    {
        $container = new ContainerBuilder();
        $definition = $container->register('dummy_service', 'Egulias\Tests\ServiceDummy');
        $definition
            ->addTag('custom_tag_name', array('method' => 'name', 'number' => 8, 'another' => 'attribute'))
            ->setPublic(true);

        $fetcher = new TagFetcher($container);

        $services = $fetcher->fetch();

        $this->assertCount(1, $services);
        $this->assertArrayHasKey('custom_tag_name', $services);
        $this->assertArrayHasKey('Egulias\Tests\ServiceDummy', $services['custom_tag_name']);
        $this->assertArrayHasKey('attributes', $services['custom_tag_name']['Egulias\Tests\ServiceDummy']);
        $this->assertArrayHasKey('definition', $services['custom_tag_name']['Egulias\Tests\ServiceDummy']);
    }
}
