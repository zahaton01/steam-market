<?php

namespace App\Application\Resources\API\TM\Proto\Sells\Model;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class TMPricing
{
    /** @var float */
    private $minPrice;
    /** @var float */
    private $maxPrice;
    /** @var float */
    private $average;
    /** @var TMSell[] */
    private $sells;
    /** @var string */
    private $hashName;

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
     * @return TMSell[]
     */
    public function getSells(): ?array
    {
        return $this->sells;
    }

    /**
     * @param TMSell $sell
     *
     * @return $this
     */
    public function addSell(TMSell $sell)
    {
        $this->sells[] = $sell;
        return $this;
    }

    /**
     * @return string
     */
    public function getHashName(): ?string
    {
        return $this->hashName;
    }

    /**
     * @param string $hashName
     *
     * @return self
     */
    public function setHashName(?string $hashName): self
    {
        $this->hashName = $hashName;
        return $this;
    }
}