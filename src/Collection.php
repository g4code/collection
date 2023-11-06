<?php

namespace G4\Collection;

use G4\ValueObject\ArrayList;
use G4\Factory\ReconstituteInterface;

class Collection implements \Iterator, \Countable
{

    private array $keyMap;

    private array $objects = [];

    private int $pointer = 0;

    private array $rawData;

    private ?int $total = null;

    public function __construct(array $rawData, private readonly ReconstituteInterface $factory)
    {
        $this->keyMap  = array_keys($rawData);
        $this->rawData = $rawData;
    }

    public function count(): int
    {
        if ($this->total === null) {
            $this->total = count($this->rawData);
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

    public function reduce(ArrayList $algorithmList): static
    {
        $this->keyMap = array_values($algorithmList->getAll());
        return $this;
    }

    public function hasData(): bool
    {
        return $this->count() > 0;
    }

    public function key(): int
    {
        return $this->pointer;
    }

    public function next(): void
    {
        if ($this->pointer < $this->count()) {
            $this->pointer++;
        }
    }

    public function rewind(): void
    {
        $this->pointer = 0;
    }

    public function valid(): bool
    {
        return $this->current() !== null;
    }

    private function addCurrentRawDataToObjects(): void
    {
        $this->factory->set($this->currentRawData());
        $this->objects[$this->pointer] = $this->factory->reconstitute();
    }

    private function currentRawData(): array
    {
        return $this->rawData[$this->keyMap[$this->pointer]];
    }

    private function hasCurrentObject(): bool
    {
        return isset($this->objects[$this->pointer]);
    }

    private function hasCurrentRawData(): bool
    {
        return isset($this->keyMap[$this->pointer]) && isset($this->rawData[$this->keyMap[$this->pointer]]);
    }

    private function currentObject(): mixed
    {
        return $this->hasCurrentObject()
            ? $this->objects[$this->pointer]
            : null;
    }
}
