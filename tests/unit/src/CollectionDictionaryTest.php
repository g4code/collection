<?php

use G4\ValueObject\ArrayList;
use G4\ValueObject\Dictionary;
use G4\Collection\CollectionDictionary;

class CollectionDictionaryTest extends \PHPUnit\Framework\TestCase
{
    private ?CollectionDictionary $collection = null;

    private ?array $data = null;

    protected function setUp(): void
    {
        $this->data = [
            0 => [
                'id' => 1,
                'data' => 'lorem ipsum',
            ],
            2 => [
                'id' => 2,
                'data' => 'lorem ipsum',
            ],
        ];
        $this->collection = new CollectionDictionary(
            new Dictionary($this->data),
            $this->getMockForFactoryReconstituteInterface()
        );
    }

    protected function tearDown(): void
    {
        $this->data = null;
        $this->collection = null;
    }

    public function testCount(): void
    {
        $this->assertEquals(2, count($this->collection));
        $this->assertEquals(
            0,
            count(new CollectionDictionary(
                new Dictionary([]),
                $this->getMockForFactoryReconstituteInterface()
            ))
        );
    }

    public function testCurrent(): void
    {
        $this->assertEquals($this->getMockForDomainEntity(), $this->collection->current());
        $this->assertEquals(0, $this->collection->key());
    }

    public function testGetRawData(): void
    {
        $this->assertEquals($this->data, $this->collection->getRawData());
    }

    public function testHasData(): void
    {
        $this->assertTrue($this->collection->hasData());

        $collection = new CollectionDictionary(new Dictionary([]), $this->getMockForFactoryReconstituteInterface());
        $this->assertFalse($collection->hasData());
    }

    public function testIteration(): void
    {
        $domains = [];
        foreach ($this->collection as $domain) {
            $domains[] = $domain;
        }
        $this->assertEquals(2, count($domains));
        $this->assertEquals($this->getMockForDomainEntity(), $domains[0]);
        $this->assertEquals($this->getMockForDomainEntity(), $domains[1]);
    }

    public function testIterationReduced(): void
    {
        $this->collection->reduce(new ArrayList([2]));
        $domains = [];
        foreach ($this->collection as $domain) {
            $domains[] = $domain;
        }
        $this->assertEquals(1, count($domains));
        $this->assertEquals($this->getMockForDomainEntity(), $domains[0]);
    }

    public function testNext(): void
    {
        $this->collection->next();
        $this->assertEquals(1, $this->collection->key());
        $this->collection->next();
        $this->assertNull($this->collection->current());
        $this->assertEquals(2, $this->collection->key());
    }

    public function testRewind(): void
    {
        $this->collection->rewind();
        $this->assertEquals(0, $this->collection->key());
    }

    public function testValid(): void
    {
        $this->assertTrue($this->collection->valid());
        $this->collection->next();
        $this->assertTrue($this->collection->valid());
        $this->collection->next();
        $this->assertFalse($this->collection->valid());
    }

    public function testKeyMapReverseOrder(): void
    {
        $this->assertEquals([0 => 0, 1 => 2], $this->collection->getKeyMap());

        $this->collection->keyMapReverseOrder();
        $this->assertEquals([0 => 2, 1 => 0], $this->collection->getKeyMap());
    }

    public function testReduce(): void
    {
        $reduce = new ArrayList([
            2,
        ]);

        $slicedResources = $this->collection->reduce($reduce);
        $this->assertCount(1, $slicedResources->getKeyMap());
        $this->assertEquals($reduce->getAll(), $slicedResources->getKeyMap());
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
}
