<?php

namespace G4\Collection;

class PaginatedCollection extends Collection implements \Iterator, \Countable
{

    private int $currentItemsCount = 0;

    private int $currentPageNumber = 1;

    private int $itemsCountPerPage = 0;

    private int $pageCount = 0;

    private int $totalItemsCount = 0;


    /**
     * @return int
     */
    public function getCurrentItemsCount(): int
    {
        return $this->currentItemsCount;
    }

    /**
     * @return int
     */
    public function getCurrentPageNumber(): int
    {
        return $this->currentPageNumber;
    }

    /**
     * @return int
     */
    public function getItemsCountPerPage(): int
    {
        return $this->itemsCountPerPage;
    }

    /**
     * @return int
     */
    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    /**
     * @return int
     */
    public function getTotalItemsCount(): int
    {
        return $this->totalItemsCount;
    }

    public function setCurrentItemsCount(int $currentItemsCount): static
    {
        $this->currentItemsCount = $currentItemsCount;
        return $this;
    }

    public function setCurrentPageNumber(int $currentPageNumber): static
    {
        $this->currentPageNumber = $currentPageNumber;
        return $this;
    }

    public function setItemsCountPerPage(int $itemsCountPerPage): static
    {
        $this->itemsCountPerPage = $itemsCountPerPage;
        return $this;
    }

    public function setPageCount(int $pageCount): static
    {
        $this->pageCount = $pageCount;
        return $this;
    }

    public function setTotalItemsCount(int $totalItemsCount): static
    {
        $this->totalItemsCount = $totalItemsCount;
        return $this;
    }

    public function map(): array
    {
        return [
            Constants::CURRENT_ITEMS       => $this->getRawData(),
            Constants::CURRENT_PAGE_NUMBER => $this->getCurrentPageNumber(),
            Constants::TOTAL_ITEM_COUNT    => $this->getTotalItemsCount(),
            Constants::ITEM_COUNT_PER_PAGE => $this->getItemsCountPerPage(),
            Constants::CURRENT_ITEM_COUNT  => $this->getCurrentItemsCount(),
            Constants::PAGE_COUNT          => $this->getPageCount(),
        ];
    }
}
