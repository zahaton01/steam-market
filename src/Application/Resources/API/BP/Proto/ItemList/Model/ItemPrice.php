<?php

namespace App\Application\Resources\API\BP\Proto\ItemList\Model;

class ItemPrice
{
    /** @var float */
    private $average;
    /** @var float */
    private $median;
    /** @var integer */
    private $sold;
    /** @var float */
    private $lowestPrice;
    /** @var float */
    private $highestPrice;

    /**
     * @return float
     */
    public function getAverage(): ?float
    {
        return $this->average;
    }

    /**
     * @param float $average
     *
     * @return self
     */
    public function setAverage(?float $average): self
    {
        $this->average = $average;
        return $this;
    }

    /**
     * @return float
     */
    public function getMedian(): ?float
    {
        return $this->median;
    }

    /**
     * @param float $median
     *
     * @return self
     */
    public function setMedian(?float $median): self
    {
        $this->median = $median;
        return $this;
    }

    /**
     * @return int
     */
    public function getSold(): ?int
    {
        return $this->sold;
    }

    /**
     * @param int $sold
     *
     * @return self
     */
    public function setSold(?int $sold): self
    {
        $this->sold = $sold;
        return $this;
    }

    /**
     * @return float
     */
    public function getLowestPrice(): ?float
    {
        return $this->lowestPrice;
    }

    /**
     * @param float $lowestPrice
     *
     * @return self
     */
    public function setLowestPrice(?float $lowestPrice): self
    {
        $this->lowestPrice = $lowestPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getHighestPrice(): ?float
    {
        return $this->highestPrice;
    }

    /**
     * @param float $highestPrice
     *
     * @return self
     */
    public function setHighestPrice(?float $highestPrice): self
    {
        $this->highestPrice = $highestPrice;
        return $this;
    }
}
