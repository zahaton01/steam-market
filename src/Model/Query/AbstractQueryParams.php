<?php

namespace App\Model\Query;

abstract class AbstractQueryParams
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
     * @return QueryFilter|null
     */
    public function getFilter(string $filterName): ?QueryFilter
    {
        if (!$this->hasFilter($filterName)) {
            return null;
        }

        return new QueryFilter($this->filters[$filterName]);
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function createFilter(string $name, $value): self
    {
        $this->filters[$name] = $value;
        return $this;
    }
}
