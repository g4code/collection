<?php

namespace G4\Collection;

use G4\DataRepository\DataRepositoryResponse;
use G4\DataRepository\Exception\MissingResponseAllDataException;
use G4\Factory\ReconstituteInterface;

class PaginatedCollectionFactory
{
    /**
     * @throws MissingResponseAllDataException
     */
    public static function create(
        DataRepositoryResponse $response,
        ReconstituteInterface  $factory,
        Pagination             $pagination
    ): PaginatedCollection {
        $collection = new PaginatedCollection($response->getAll(), $factory);
        $collection
            ->setItemsCountPerPage($pagination->getPerPage())
            ->setCurrentPageNumber($pagination->getPage())
            ->setPageCount((int)$pagination->calculatePageCount($response->getTotal()))
            ->setTotalItemsCount((int)$response->getTotal())
            ->setCurrentItemsCount($response->count());
        return $collection;
    }

    public static function createEmpty(ReconstituteInterface $factory, Pagination $pagination): PaginatedCollection
    {
        $collection = new PaginatedCollection([], $factory);
        $collection
            ->setCurrentItemsCount($collection->getCurrentItemsCount())
            ->setTotalItemsCount($collection->getTotalItemsCount())
            ->setItemsCountPerPage($pagination->getPerPage())
            ->setCurrentPageNumber($pagination->getPage());
        return $collection;
    }
}
