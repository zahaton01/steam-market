<?php

namespace App\Domain\Query;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractQuery
{
    /** @var array  */
    protected $filters = [];

    /**
     * @return array
     */
    public function getFilters(): ?array
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     *
     * @return self
     */
    public function setFilters(?array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * @param string $filterName
     * @return bool
     */
    public function hasFilter(string $filterName)
    {
        $value = $this->filters[$filterName] ?? null;

        if (null === $value || $value === '') {
            return false;
        }

        return true;
    }

    /**
     * @param string $filterName
     * @return AbstractQueryFilter|null
     */
    abstract function getFilter(string $filterName): ?AbstractQueryFilter;
}