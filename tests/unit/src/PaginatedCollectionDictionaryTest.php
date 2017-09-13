<?php

use G4\ValueObject\Dictionary;
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

    protected function setUp()
    {
        $this->dataMock = $this->getMockBuilder(Dictionary::class)
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
        $this->fixture      = null;
        $this->dataMock     = null;
        $this->collection   = null;
    }

    public function testCurrentItemsCount()
    {
        $this->collection->setCurrentItemsCount($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getCurrentItemsCount());
    }

    public function testCurrentPageNumber()
    {
        $this->collection->setCurrentPageNumber($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getCurrentPageNumber());
    }

    public function testItemsCountPerPage()
    {
        $this->collection->setItemsCountPerPage($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getItemsCountPerPage());
    }

    public function testPageCount()
    {
        $this->collection->setPageCount($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getPageCount());
    }

    public function testTotalItemsCount()
    {
        $this->collection->setTotalItemsCount($this->fixture);
        $this->assertEquals($this->fixture, $this->collection->getTotalItemsCount());
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