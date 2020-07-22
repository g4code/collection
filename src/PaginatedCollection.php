<?php

namespace G4\Collection;

class PaginatedCollection extends Collection implements \Iterator, \Countable
{

    /**
     * @var int
     */
    private $currentItemsCount;

    /**
     * @var int
     */
    private $currentPageNumber;

    /**
     * @var int
     */
    private $itemsCountPerPage;

    /**
     * @var int
     */
    private $pageCount;

    /**
     * @var int
     */
    private $totalItemsCount;


    /**
     * @return int
     */
    public function getCurrentItemsCount()
    {
        return $this->currentItemsCount;
    }

    /**
     * @return int
     */
    public function getCurrentPageNumber()
    {
        return $this->currentPageNumber;
    }

    /**
     * @return int
     */
    public function getItemsCountPerPage()
    {
        return $this->itemsCountPerPage;
    }

    /**
     * @return int
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * @return int
     */
    public function getTotalItemsCount()
    {
        return $this->totalItemsCount;
    }

    /**
     * @param $currentItemsCount int
     * @return $this
     */
    public function setCurrentItemsCount($currentItemsCount)
    {
        $this->currentItemsCount = $currentItemsCount;
        return $this;
    }

    /**
     * @param $currentPageNumber int
     * @return $this
     */
    public function setCurrentPageNumber($currentPageNumber)
    {
        $this->currentPageNumber = $currentPageNumber;
        return $this;
    }

    /**
     * @param $itemsCountPerPage int
     * @return $this
     */
    public function setItemsCountPerPage($itemsCountPerPage)
    {
        $this->itemsCountPerPage = $itemsCountPerPage;
        return $this;
    }

    /**
     * @param $pageCount int
     * @return $this
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;
        return $this;
    }

    /**
     * @param $totalItemsCount int
     * @return $this
     */
    public function setTotalItemsCount($totalItemsCount)
    {
        $this->totalItemsCount = $totalItemsCount;
        return $this;
    }

    public function map()
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
