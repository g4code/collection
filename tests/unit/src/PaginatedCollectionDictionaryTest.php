<?php

use G4\ValueObject\Dictionary;
use G4\ValueObject\IntegerNumber;
use G4\Collection\PaginatedCollectionDictionary;
use PHPUnit\Framework\MockObject\MockObject;

class PaginatedCollectionDictionaryTest extends \PHPUnit\Framework\TestCase
{
    private ?PaginatedCollectionDictionary $collection = null;

    private ?MockObject $dataMock = null;

    private ?int $fixture = null;

    private ?MockObject $pageCountMock = null;
    private ?MockObject $totalItemsCountMock = null;
    private ?MockObject $itemsCountPerPageMock = null;
    private ?MockObject $currentPageNumberMock = null;
    private ?MockObject $currentItemsCountMock = null;

    protected function setUp(): void
    {
        $this->dataMock = $this->createMock(Dictionary::class);

        $this->currentItemsCountMock = $this->createMock(IntegerNumber::class);

        $this->currentPageNumberMock = $this->createMock(IntegerNumber::class);

        $this->itemsCountPerPageMock = $this->createMock(IntegerNumber::class);

        $this->pageCountMock = $this->createMock(IntegerNumber::class);

        $this->totalItemsCountMock = $this->createMock(IntegerNumber::class);

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

        $this->collection = new PaginatedCollectionDictionary(
            $this->dataMock,
            $this->getMockForFactoryReconstituteInterface()
        );
    }

    protected function tearDown(): void
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

    public function testCurrentItemsCount(): void
    {
        $this->currentItemsCountMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setCurrentItemsCount($this->currentItemsCountMock);
        $this->assertEquals($this->fixture, $this->collection->getCurrentItemsCount()->getValue());
    }

    public function testCurrentPageNumber(): void
    {
        $this->currentPageNumberMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setCurrentPageNumber($this->currentPageNumberMock);
        $this->assertEquals($this->fixture, $this->collection->getCurrentPageNumber()->getValue());
    }

    public function testItemsCountPerPage(): void
    {
        $this->itemsCountPerPageMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setItemsCountPerPage($this->itemsCountPerPageMock);
        $this->assertEquals($this->fixture, $this->collection->getItemsCountPerPage()->getValue());
    }

    public function testPageCount(): void
    {
        $this->pageCountMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setPageCount($this->pageCountMock);
        $this->assertEquals($this->fixture, $this->collection->getPageCount()->getValue());
    }

    public function testTotalItemsCount(): void
    {
        $this->totalItemsCountMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($this->fixture);

        $this->collection->setTotalItemsCount($this->totalItemsCountMock);
        $this->assertEquals($this->fixture, $this->collection->getTotalItemsCount()->getValue());
    }

    public function testMap(): void
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

    private function getMockForFactoryReconstituteInterface(): \G4\Factory\ReconstituteInterface&MockObject
    {
        $mock = $this->createMock(\G4\Factory\ReconstituteInterface::class);

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
        return $this->getMockBuilder('Domain')->getMock();
    }
}
