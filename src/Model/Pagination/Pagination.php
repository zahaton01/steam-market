<?php

namespace App\Model\Pagination;

class Pagination
{
    /** @var integer */
    private $pageSize;
    /** @var integer */
    private $page;
    /** @var int */
    private $totalItems;

    /**
     * Pagination constructor.
     * @param int $pageSize
     * @param int $page
     */
    public function __construct(int $pageSize, int $page)
    {
        $this->pageSize = $pageSize;
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPageSize(): ?int
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize
     *
     * @return self
     */
    public function setPageSize(?int $pageSize): self
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    /**
     * @return int
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return self
     */
    public function setPage(?int $page): self
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalItems(): ?int
    {
        return $this->totalItems;
    }

    /**
     * @param int $totalItems
     *
     * @return self
     */
    public function setTotalItems(?int $totalItems): self
    {
        $this->totalItems = $totalItems;
        return $this;
    }

    /**
     * @return int
     */
    public function getFirstResult()
    {
        return $this->pageSize * ($this->page - 1);
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return ceil($this->totalItems / $this->pageSize);
    }
}