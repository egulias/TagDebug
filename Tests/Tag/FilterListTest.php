<?php

namespace Egulias\TagDebug\Tests\Tag;

use Egulias\TagDebug\Tag\FilterList;

class FilterListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testFilterAdmitsOnlyFilterInterfaceWhenConstructing()
    {
        new FilterList(array(new \StdClass()));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFilterAdmitsOnlyFilterInterfaceOnAppend()
    {
        $filterList = new FilterList(array());
        $filterList->append(new \StdClass);
    }

    public function testFilterListAddFilter()
    {
        $filterMock = $this->getMockForAbstractClass('Egulias\TagDebug\Tag\Filter');
        $filterList = new FilterList();
        $filterList->append($filterMock);

        $this->assertCount(1, $filterList);
    }
}