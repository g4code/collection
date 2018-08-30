<?php

namespace G4\Collection;

use G4\ValueObject\ArrayList;
use G4\ValueObject\Dictionary;
use G4\Factory\ReconstituteInterface;

class CollectionDictionary implements \Iterator, \Countable
{
    /**
     * @var Dictionary
     */
    private $dictionary;

    /**
     * @var ReconstituteInterface
     */
    private $factory;

    /**
     * @var int
     */
    private $total;

    /**
     * @var array
     */
    private $keyMap;

    /**
     * @var array
     */
    private $rawData;

    /**
     * @var int
     */
    private $pointer;

    /**
     * @var array
     */
    private $objects;

    /**
     * CollectionDictionary constructor.
     * @param Dictionary $dictionary
     * @param ReconstituteInterface $factory
     */
    public function __construct(Dictionary $dictionary, ReconstituteInterface $factory)
    {
        $this->dictionary = $dictionary;
        $this->factory    = $factory;
        $this->keyMap     = array_keys($dictionary->getAll());
        $this->rawData    = $dictionary->getAll();
        $this->pointer    = 0;
        $this->objects    = [];
    }

    /**
     * Count elements of an object
     * @return int The custom count as an integer.
     */
    public function count()
    {
        if ($this->total === null) {
            $this->total = count($this->dictionary->getAll());
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
     * Move forward to next element
     */
    public function next()
    {
        if ($this->pointer < $this->count()) {
            $this->pointer++;
        }
    }

    /**
     * Return the key of the current element
     * @return int
     */
    public function key()
    {
        return $this->pointer;
    }

    /**
     * Checks if current position is valid
     * @return bool
     */
    public function valid()
    {
        return $this->current() !== null;
    }

    /**
     * Rewind the Iterator to the first element
     * @return $this
     */
    public function rewind()
    {
        $this->pointer = 0;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasData()
    {
        return $this->count() > 0;
    }

    /**
     * @return array
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @return array
     */
    public function getKeyMap()
    {
        return $this->keyMap;
    }

    /**
     * @return $this
     */
    public function keyMapReverseOrder()
    {
        $this->keyMap = array_reverse($this->keyMap);
        return $this;
    }

    /**
     * @param ArrayList $algorithmList
     * @return $this
     */
    public function reduce(ArrayList $algorithmList)
    {
        $this->keyMap = array_values($algorithmList->getAll());
        return $this;
    }

    /**
     * @return bool
     */
    private function hasCurrentRawData()
    {
        return isset($this->keyMap[$this->pointer]) && isset($this->rawData[$this->keyMap[$this->pointer]]);
    }

    /**
     * @return bool
     */
    private function hasCurrentObject()
    {
        return isset($this->objects[$this->pointer]);
    }

    /**
     * @return array
     */
    private function currentRawData()
    {
        return $this->rawData[$this->keyMap[$this->pointer]];
    }

    /**
     * Adds the reconstituted entity objects to objects array
     */
    private function addCurrentRawDataToObjects()
    {
        $this->factory->set(new Dictionary($this->currentRawData()));
        $this->objects[$this->pointer] = $this->factory->reconstitute();
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
