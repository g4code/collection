<?php

namespace G4\Collection;

use AllowDynamicProperties;
use G4\Constants\Parameters;

#[AllowDynamicProperties]
class Pagination
{
    private int $page;
    private int $perPage;

    final public const DEFAULT_PAGE = 1;
    final public const DEFAULT_PER_PAGE = 20;

    public function __construct(array $params = [])
    {
        $this->page = array_key_exists(Parameters::PAGE, $params)
            ? (int) $params[Parameters::PAGE] : self::DEFAULT_PAGE;
        $this->perPage = array_key_exists(Parameters::PER_PAGE, $params)
            ? (int) $params[Parameters::PER_PAGE] : self::DEFAULT_PER_PAGE;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function calculatePageCount($totalNumberOfRecords): float
    {
        return ceil($totalNumberOfRecords / $this->getPerPage());
    }
}
