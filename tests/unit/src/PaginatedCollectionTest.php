<?php

use G4\Collection\PaginatedCollection;
use G4\ValueObject\Dictionary;
use PHPUnit\Framework\MockObject\MockObject;

class PaginatedCollectionTest extends \PHPUnit\Framework\TestCase
{

    private ?PaginatedCollection $collection = null;

    private ?MockObject $dataMock = null;

    private ?int $fixture = null;


    protected function setUp(): void
    {
        $this->dataMock = $this->createMock(Dictionary::class);

        $this->fixture = 23;

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

        $this->collection = new PaginatedCollection(
            $this->dataMock->getAll(),
            $this->getMockForFactoryReconstituteInterface()
        );
    }

    protected function tearDown(): void
    {
        $this->fixture      = null;
        $this->dataMock     = null;
        $this->collection   = null;
    }

    public function testCurrentItemsCount(): void
    {
        $this->collection->setCurrentItemsCount($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getCurrentItemsCount());
    }

    public function testCurrentPageNumber(): void
    {
        $this->collection->setCurrentPageNumber($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getCurrentPageNumber());
    }

    public function testItemsCountPerPage(): void
    {
        $this->collection->setItemsCountPerPage($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getItemsCountPerPage());
    }

    public function testPageCount(): void
    {
        $this->collection->setPageCount($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getPageCount());
    }

    public function testTotalItemsCount(): void
    {
        $this->collection->setTotalItemsCount($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getTotalItemsCount());
    }

    public function testMap(): void
    {
        $this->collection->setCurrentPageNumber($this->fixture);
        $this->collection->setTotalItemsCount($this->fixture);
        $this->collection->setItemsCountPerPage($this->fixture);
        $this->collection->setCurrentItemsCount($this->fixture);
        $this->collection->setPageCount($this->fixture);

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

    public function testCreateEmptyCollection(): void
    {
        $result = new PaginatedCollection([], $this->getMockForFactoryReconstituteInterface());

        $this->assertEquals(0, $result->getCurrentItemsCount());
        $this->assertEquals(0, $result->getTotalItemsCount());
    }
}