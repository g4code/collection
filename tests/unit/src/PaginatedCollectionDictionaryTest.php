<?php

use G4\ValueObject\Dictionary;
use G4\ValueObject\IntegerNumber;
use G4\Collection\PaginatedCollectionDictionary;

class PaginatedCollectionDictionaryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PaginatedCollectionDictionary
     */
    private $collection;

    /**
     * @var array
     */
    private $dataMock;

    /**
     * @var int
     */
    private $fixture;

    private $pageCountMock;
    private $totalItemsCountMock;
    private $itemsCountPerPageMock;
    private $currentPageNumberMock;
    private $currentItemsCountMock;

    protected function setUp()
    {
        $this->dataMock = $this->getMockBuilder(Dictionary::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentItemsCountMock = $this->getMockBuilder(IntegerNumber::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentPageNumberMock = $this->getMockBuilder(IntegerNumber::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemsCountPerPageMock = $this->getMockBuilder(IntegerNumber::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageCountMock = $this->getMockBuilder(IntegerNumber::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->totalItemsCountMock = $this->getMockBuilder(IntegerNumber::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dataMock
            ->expects($this->any())
            ->method('getAll')
            ->willReturn([
                0 => [
                    'id' => 1,
                    'data' => 'lorem ipsum',
                ],
                2 => [
                    'id' => 2,
                    'data' => 'lorem ipsum',
                ]
            ]);

        $this->fixture = 23;

        $this->collection = new PaginatedCollectionDictionary($this->dataMock, $this->getMockForFactoryReconstituteInterface());
    }

    protected function tearDown()
    {
        $this->fixture                  = null;
        $this->dataMock                 = null;
        $this->collection               = null;
        $this->pageCountMock            = null;
        $this->totalItemsCountMock      = null;
        $this->itemsCountPerPageMock    = null;
        $this->currentItemsCountMock    = null;
        $this->currentPageNumberMock    = null;
    }

    public function testCurrentItemsCount()
    {
        $this->currentItemsCountMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setCurrentItemsCount($this->currentItemsCountMock);
        $this->assertEquals($this->fixture, $this->collection->getCurrentItemsCount()->getValue());
    }

    public function testCurrentPageNumber()
    {
        $this->currentPageNumberMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setCurrentPageNumber($this->currentPageNumberMock);
        $this->assertEquals($this->fixture, $this->collection->getCurrentPageNumber()->getValue());
    }

    public function testItemsCountPerPage()
    {
        $this->itemsCountPerPageMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setItemsCountPerPage($this->itemsCountPerPageMock);
        $this->assertEquals($this->fixture, $this->collection->getItemsCountPerPage()->getValue());
    }

    public function testPageCount()
    {
        $this->pageCountMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setPageCount($this->pageCountMock);
        $this->assertEquals($this->fixture, $this->collection->getPageCount()->getValue());
    }

    public function testTotalItemsCount()
    {
        $this->totalItemsCountMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setTotalItemsCount($this->totalItemsCountMock);
        $this->assertEquals($this->fixture, $this->collection->getTotalItemsCount()->getValue());
    }

    public function testMap()
    {
        $this->currentPageNumberMock->expects($this->once())->method('getValue')->willReturn($this->fixture);
        $this->totalItemsCountMock->expects($this->once())->method('getValue')->willReturn($this->fixture);
        $this->itemsCountPerPageMock->expects($this->once())->method('getValue')->willReturn($this->fixture);
        $this->currentItemsCountMock->expects($this->once())->method('getValue')->willReturn($this->fixture);
        $this->pageCountMock->expects($this->once())->method('getValue')->willReturn($this->fixture);

        $this->collection->setCurrentPageNumber($this->currentPageNumberMock);
        $this->collection->setTotalItemsCount($this->totalItemsCountMock);
        $this->collection->setItemsCountPerPage($this->itemsCountPerPageMock);
        $this->collection->setCurrentItemsCount($this->currentItemsCountMock);
        $this->collection->setPageCount($this->pageCountMock);

        $map = [
            'current_items'         => $this->dataMock->getAll(),
            'current_page_number'   => $this->fixture,
            'total_item_count'      => $this->fixture,
            'item_count_per_page'   => $this->fixture,
            'current_item_count'    => $this->fixture,
            'page_count'            => $this->fixture,
        ];

        $this->assertEquals($map, $this->collection->map());
    }

    private function getMockForFactoryReconstituteInterface()
    {
        $mock = $this->getMockBuilder('\G4\Factory\ReconstituteInterface')
            ->setMethods(['set', 'reconstitute'])
            ->getMock('\G4\Factory\ReconstituteInterface');

        $mock
            ->expects($this->any())
            ->method('set');

        $mock
            ->expects($this->any())
            ->method('reconstitute')
            ->willReturn($this->getMockForDomainEntity());

        return $mock;
    }

    private function getMockForDomainEntity()
    {
        $mock = $this->getMockBuilder('Domain')->getMock();
        return $mock;
    }
}