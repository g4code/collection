<?php

namespace G4\Collection;

use G4\ValueObject\IntegerNumber;

class PaginatedCollectionDictionary extends CollectionDictionary implements \Iterator, \Countable
{
    private ?IntegerNumber $currentItemsCount = null;

    private ?IntegerNumber $currentPageNumber = null;

    private ?IntegerNumber $itemsCountPerPage = null;

    private ?IntegerNumber $pageCount = null;

    private ?IntegerNumber $totalItemsCount = null;

    public function getCurrentItemsCount(): ?IntegerNumber
    {
        return $this->currentItemsCount;
    }

    public function getCurrentPageNumber(): ?IntegerNumber
    {
        return $this->currentPageNumber;
    }

    public function getItemsCountPerPage(): ?IntegerNumber
    {
        return $this->itemsCountPerPage;
    }

    public function getPageCount(): ?IntegerNumber
    {
        return $this->pageCount;
    }

    public function getTotalItemsCount(): ?IntegerNumber
    {
        return $this->totalItemsCount;
    }

    public function setCurrentItemsCount(IntegerNumber $currentItemsCount): static
    {
        $this->currentItemsCount = $currentItemsCount;
        return $this;
    }

    public function setCurrentPageNumber(IntegerNumber $currentPageNumber): static
    {
        $this->currentPageNumber = $currentPageNumber;
        return $this;
    }

    public function setItemsCountPerPage(IntegerNumber $itemsCountPerPage): static
    {
        $this->itemsCountPerPage = $itemsCountPerPage;
        return $this;
    }

    public function setPageCount(IntegerNumber $pageCount): static
    {
        $this->pageCount = $pageCount;
        return $this;
    }

    public function setTotalItemsCount(IntegerNumber $totalItemsCount): static
    {
        $this->totalItemsCount = $totalItemsCount;
        return $this;
    }

    public function map(): array
    {
        return [
            Constants::CURRENT_ITEMS       => $this->getRawData(),
            Constants::CURRENT_PAGE_NUMBER => $this->getCurrentPageNumber()?->getValue(),
            Constants::TOTAL_ITEM_COUNT    => $this->getTotalItemsCount()?->getValue(),
            Constants::ITEM_COUNT_PER_PAGE => $this->getItemsCountPerPage()?->getValue(),
            Constants::CURRENT_ITEM_COUNT  => $this->getCurrentItemsCount()?->getValue(),
            Constants::PAGE_COUNT          => $this->getPageCount()?->getValue(),
        ];
    }
}
