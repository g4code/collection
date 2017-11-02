<?php

namespace G4\Collection;

use G4\ValueObject\IntegerNumber;

class PaginatedCollectionDictionary extends CollectionDictionary implements \Iterator, \Countable
{
    /**
     * @var IntegerNumber
     */
    private $currentItemsCount;

    /**
     * @var IntegerNumber
     */
    private $currentPageNumber;

    /**
     * @var IntegerNumber
     */
    private $itemsCountPerPage;

    /**
     * @var IntegerNumber
     */
    private $pageCount;

    /**
     * @var IntegerNumber
     */
    private $totalItemsCount;

    /**
     * @return IntegerNumber
     */
    public function getCurrentItemsCount()
    {
        return $this->currentItemsCount;
    }

    /**
     * @return IntegerNumber
     */
    public function getCurrentPageNumber()
    {
        return $this->currentPageNumber;
    }

    /**
     * @return IntegerNumber
     */
    public function getItemsCountPerPage()
    {
        return $this->itemsCountPerPage;
    }

    /**
     * @return IntegerNumber
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * @return IntegerNumber
     */
    public function getTotalItemsCount()
    {
        return $this->totalItemsCount;
    }

    /**
     * @param IntegerNumber $currentItemsCount
     * @return $this
     */
    public function setCurrentItemsCount(IntegerNumber $currentItemsCount)
    {
        $this->currentItemsCount = $currentItemsCount;
        return $this;
    }

    /**
     * @param IntegerNumber $currentPageNumber
     * @return $this
     */
    public function setCurrentPageNumber(IntegerNumber $currentPageNumber)
    {
        $this->currentPageNumber = $currentPageNumber;
        return $this;
    }

    /**
     * @param IntegerNumber $itemsCountPerPage
     * @return $this
     */
    public function setItemsCountPerPage(IntegerNumber $itemsCountPerPage)
    {
        $this->itemsCountPerPage = $itemsCountPerPage;
        return $this;
    }

    /**
     * @param IntegerNumber $pageCount
     * @return $this
     */
    public function setPageCount(IntegerNumber $pageCount)
    {
        $this->pageCount = $pageCount;
        return $this;
    }

    /**
     * @param IntegerNumber $totalItemsCount
     * @return $this
     */
    public function setTotalItemsCount(IntegerNumber $totalItemsCount)
    {
        $this->totalItemsCount = $totalItemsCount;
        return $this;
    }
}