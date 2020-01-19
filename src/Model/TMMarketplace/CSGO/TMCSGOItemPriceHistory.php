<?php

namespace App\Model\TMMarketplace\CSGO;

class TMCSGOItemPriceHistory
{
    /** @var float */
    private $minPrice;
    /** @var float */
    private $maxPrice;
    /** @var float */
    private $average;
    /** @var TMCSGOItemSellHistory[] */
    private $sells;

    /**
     * @return float
     */
    public function getMinPrice(): ?float
    {
        return $this->minPrice;
    }

    /**
     * @param float $minPrice
     *
     * @return self
     */
    public function setMinPrice(?float $minPrice): self
    {
        $this->minPrice = $minPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }

    /**
     * @param float $maxPrice
     *
     * @return self
     */
    public function setMaxPrice(?float $maxPrice): self
    {
        $this->maxPrice = $maxPrice;
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
     * @return TMCSGOItemSellHistory[]
     */
    public function getSells(): ?array
    {
        return $this->sells;
    }

    /**
     * @param TMCSGOItemSellHistory[] $sells
     *
     * @return self
     */
    public function setSells(?array $sells): self
    {
        $this->sells = $sells;
        return $this;
    }

    /**
     * @param TMCSGOItemSellHistory $history
     *
     * @return $this
     */
    public function addSell(TMCSGOItemSellHistory $history)
    {
        $this->sells[] = $history;

        return $this;
    }
}