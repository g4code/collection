<?php

namespace G4\Collection;

use G4\Factory\ReconstituteInterface;

class Collection implements \Iterator, \Countable
{

    /**
     * @var ReconstituteInterface
     */
    private $factory;

    /**
     * @var array
     */
    private $objects;

    /**
     * @var int
     */
    private $pointer;

    /**
     * @var array
     */
    private $rawData;

    /**
     * @var int
     */
    private $total;

    /**
     * @param array $rawData
     * @param ReconstituteInterface $factory
     */
    public function __construct(array $rawData, ReconstituteInterface $factory)
    {
        $this->objects = [];
        $this->pointer = 0;
        $this->rawData = $rawData;
        $this->factory = $factory;

    }

    /**
     * @return int
     */
    public function count()
    {
        if ($this->total === null) {
            $this->total = count($this->rawData);
        }
        return $this->total;
    }

    public function current()
    {
        return $this->getObject();
    }

    /**
     * @return array
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    public function rewind()
    {
        $this->pointer = 0;
        return $this;
    }

    public function next()
    {
        $object = $this->getObject();
        if ($object !== null) {
            $this->pointer++;
        }
        return $object;
    }

    public function key()
    {
        return $this->pointer;
    }

    public function valid()
    {
        return $this->current() !== null;
    }

    private function addCurrentRawDataToObjects()
    {
        $this->factory->set($this->getCurrentRawData());
        $this->objects[$this->pointer] = $this->factory->reconstitute();
        return $this;
    }

    private function getObject()
    {
        if ($this->pointer >= $this->count()) {
            return null;
        }
        if($this->hasCurrentObject()){
            return $this->currentObject();
        }
        if($this->hasCurrentRawData()){
            $this->addCurrentRawDataToObjects();
            return $this->currentObject();
        }
        return null;
    }

    private function getCurrentRawData()
    {
        return $this->rawData[$this->pointer];
    }

    private function hasCurrentObject()
    {
        return isset($this->objects[$this->pointer]);
    }

    private function hasCurrentRawData()
    {
        return isset($this->rawData[$this->pointer]);
    }

    private function currentObject()
    {
        return $this->hasCurrentObject()
            ? $this->objects[$this->pointer]
            : null;
    }
}