<?php

namespace App\Proto\BP\ItemList;

use App\Proto\AbstractProto;

class ItemPriceProto extends AbstractProto
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
     * @param null $data
     * @param array $params
     *
     * @return $this|mixed
     */
    public function init($data = null, array $params = [])
    {
        if (null !== $data && !$this->hasProto()) {
            $this->average = $data['average'];
            $this->median = $data['median'];
            $this->sold = $data['sold'];
            $this->lowestPrice = $data['lowest_price'];
            $this->highestPrice = $data['highest_price'];
        }

        return $this;
    }

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
