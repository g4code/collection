<?php

namespace G4\Collection;

use G4\Constants\Parameters;

class Pagination
{
    /**
     * @var int
     */
    private $page;
    /**
     * @var int
     */
    private $perPage;

    const DEFAULT_PAGE = 1;
    const DEFAULT_PER_PAGE = 20;

    public function __construct(array $params = [])
    {
        $this->page = array_key_exists(Parameters::PAGE, $params)
            ? $params[Parameters::PAGE] : self::DEFAULT_PAGE;
        $this->perPage = array_key_exists(Parameters::PER_PAGE, $params)
            ? $params[Parameters::PER_PAGE] : self::DEFAULT_PER_PAGE;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function calculatePageCount($totalNumberOfRecords)
    {
        return ceil($totalNumberOfRecords / $this->getPerPage());
    }
}
