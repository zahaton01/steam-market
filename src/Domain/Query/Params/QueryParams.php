<?php

namespace App\Domain\Query\Params;

use App\Domain\Query\AbstractQuery;
use App\Domain\Query\AbstractQueryFilter;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class QueryParams extends AbstractQuery
{
    /** @var \DateTime  */
    private $startDate = null;

    /** @var \DateTime  */
    private $endDate = null;

    /**
     * @param string $filterName
     * @return AbstractQueryFilter|null
     */
    public function getFilter(string $filterName): ?AbstractQueryFilter
    {
        if (!$this->hasFilter($filterName)) {
            return null;
        }

        return new QueryFilter($this->filters[$filterName]);
    }

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
}