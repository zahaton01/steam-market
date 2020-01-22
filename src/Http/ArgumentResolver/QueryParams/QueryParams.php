<?php

namespace App\Http\ArgumentResolver\QueryParams;

class QueryParams
{
    /** @var \DateTime  */
    private $startDate = null;
    /** @var \DateTime  */
    private $endDate = null;
    /** @var array  */
    private $filters = [];

    /**
     * @return \DateTime
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return self
     */
    public function setStartDate(?\DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     *
     * @return self
     */
    public function setEndDate(?\DateTime $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasStartDate()
    {
        return null !== $this->startDate;
    }

    /**
     * @return bool
     */
    public function hasEndDate()
    {
        return null !== $this->endDate;
    }

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
