<?php

use G4\Collection\Collection;

class CollectionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var array
     */
    private $data;


    protected function setUp()
    {
        $this->data = [
            [
                'id' => 1,
                'data' => 'lorem ipsum',
            ],
            [
                'id' => 2,
                'data' => 'lorem ipsum',
            ],
        ];
        $this->collection = new Collection($this->data, $this->getMock('\G4\Factory\ReconstituteInterface'));
    }

    protected function tearDown()
    {
        $this->data       = null;
        $this->collection = null;
    }


    public function testCount()
    {
        $this->assertEquals(2, count($this->collection));

        $this->assertEquals(0, count(new Collection([], $this->getMock('\G4\Factory\ReconstituteInterface'))));
    }

    public function testCurrent()
    {
        $this->collection->current();
    }

}