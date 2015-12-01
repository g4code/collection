<?php

namespace G4\Collection;

use G4\Factory\ReconstituteInterface;

class Collection implements \Iterator, \Countable
{

    private $objects = [];

    private $rawData;

    private $total = 0;

    private $pointer = 0;

    private $factory;

    public function __construct(array $rawData, ReconstituteInterface $factory)
    {
        $this->rawData = $rawData;
        $this->factory = $factory;
        $this->total = count($rawData);
    }

    public function count()
    {
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

    /**
     * @return Collection
     */
    public function rewind()
    {
        $this->pointer = 0;
        return $this;
    }

    public function next()
    {
        $object = $this->getObject();
        if(!empty($object)){
            $this->incrementPointer();
        }
        return $object;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->pointer;
    }

    public function valid()
    {
        return !is_null( $this->current() );
    }

    public function incrementPointer()
    {
        $this->pointer++;
        return $this;
    }

    private function addToObject($data)
    {
        $this->objects[$this->pointer] = $this
            ->factory
            ->set($data)
            ->reconstitute();
        return $this;
    }

    private function getObject()
    {
        if ($this->pointer >= $this->total || $this->pointer < 0) {
            return null;
        }
        if($this->hasCurrentObject()){
            return $this->currentObject();
        }
        if($this->hasCurrentRawData()){
            $this->addToObject($this->getCurrentRawData());
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
        return isset($this->objects[$this->pointer])
            ? $this->objects[$this->pointer]
            : null;
    }

}