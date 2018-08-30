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
    private $keyMap;

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
        $this->factory = $factory;
        $this->keyMap  = array_keys($rawData);
        $this->objects = [];
        $this->pointer = 0;
        $this->rawData = $rawData;
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

    /**
     * @return mixed|null
     */
    public function current()
    {
        if ($this->pointer >= $this->count()) {
            return null;
        }
        if ($this->hasCurrentObject()) {
            return $this->currentObject();
        }
        if ($this->hasCurrentRawData()) {
            $this->addCurrentRawDataToObjects();
            return $this->currentObject();
        }
    }

    /**
     * @return array
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    public function hasData()
    {
        return $this->count() > 0;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->pointer;
    }

    public function next()
    {
        if ($this->pointer < $this->count()) {
            $this->pointer++;
        }
    }

    public function rewind()
    {
        $this->pointer = 0;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->current() !== null;
    }

    private function addCurrentRawDataToObjects()
    {
        $this->factory->set($this->currentRawData());
        $this->objects[$this->pointer] = $this->factory->reconstitute();
    }

    /**
     * @return array
     */
    private function currentRawData()
    {
        return $this->rawData[$this->keyMap[$this->pointer]];
    }

    /**
     * @return bool
     */
    private function hasCurrentObject()
    {
        return isset($this->objects[$this->pointer]);
    }

    /**
     * @return bool
     */
    private function hasCurrentRawData()
    {
        return isset($this->keyMap[$this->pointer]) && isset($this->rawData[$this->keyMap[$this->pointer]]);
    }

    /**
     * @return mixed|null
     */
    private function currentObject()
    {
        return $this->hasCurrentObject()
            ? $this->objects[$this->pointer]
            : null;
    }
}
