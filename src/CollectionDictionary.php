<?php

namespace G4\Collection;

use G4\ValueObject\ArrayList;
use G4\ValueObject\Dictionary;
use G4\Factory\ReconstituteInterface;
use ReturnTypeWillChange;

class CollectionDictionary implements \Iterator, \Countable
{
    private ?int $total = null;

    private array $keyMap;

    private array $rawData;

    private int $pointer = 0;

    private array $objects = [];

    /**
     * CollectionDictionary constructor.
     */
    public function __construct(
        private readonly Dictionary $dictionary,
        private readonly ReconstituteInterface $factory
    ) {
        $this->keyMap = array_keys($dictionary->getAll());
        $this->rawData = $dictionary->getAll();
    }

    public function count(): int
    {
        if ($this->total === null) {
            $this->total = count($this->dictionary->getAll());
        }
        return $this->total;
    }

    public function current(): mixed
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

        return null;
    }

    /**
     * Move forward to next element
     */
    public function next(): void
    {
        if ($this->pointer < $this->count()) {
            $this->pointer++;
        }
    }

    /**
     * Return the key of the current element
     */
    public function key(): int
    {
        return $this->pointer;
    }

    /**
     * Checks if current position is valid
     */
    public function valid(): bool
    {
        return $this->current() !== null;
    }

    /**
     * Rewind the Iterator to the first element
     */
    #[ReturnTypeWillChange]
    public function rewind()
    {
        $this->pointer = 0;
        return $this;
    }

    public function hasData(): bool
    {
        return $this->count() > 0;
    }

    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function getKeyMap(): array
    {
        return $this->keyMap;
    }

    public function keyMapReverseOrder(): static
    {
        $this->keyMap = array_reverse($this->keyMap);
        return $this;
    }

    public function reduce(ArrayList $arrayList): static
    {
        $this->keyMap = array_values($arrayList->getAll());
        return $this;
    }

    private function hasCurrentRawData(): bool
    {
        return isset($this->keyMap[$this->pointer]) && isset($this->rawData[$this->keyMap[$this->pointer]]);
    }

    private function hasCurrentObject(): bool
    {
        return isset($this->objects[$this->pointer]);
    }

    private function currentRawData(): array
    {
        return $this->rawData[$this->keyMap[$this->pointer]];
    }

    /**
     * Adds the reconstituted entity objects to objects array
     */
    private function addCurrentRawDataToObjects(): void
    {
        $this->factory->set(new Dictionary($this->currentRawData()));
        $this->objects[$this->pointer] = $this->factory->reconstitute();
    }

    private function currentObject(): mixed
    {
        return $this->hasCurrentObject()
            ? $this->objects[$this->pointer]
            : null;
    }
}
