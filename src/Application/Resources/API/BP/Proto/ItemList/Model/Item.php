<?php

namespace App\Application\Resources\API\BP\Proto\ItemList\Model;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class Item
{
    public const DAY = '24_hours';
    public const WEEK = '7_days';
    public const MONTH = '30_days';
    public const ALL = 'all_time';

    /** @var string */
    private $hashName;
    /** @var ItemPrice */
    private $dayPrice;
    /** @var ItemPrice */
    private $weekPrice;
    /** @var ItemPrice */
    private $monthPrice;
    /** @var ItemPrice */
    private $allTimePrice;

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

    /**
     * @return ItemPrice
     */
    public function getDayPrice(): ?ItemPrice
    {
        return $this->dayPrice;
    }

    /**
     * @param ItemPrice $dayPrice
     *
     * @return self
     */
    public function setDayPrice(?ItemPrice $dayPrice): self
    {
        $this->dayPrice = $dayPrice;
        return $this;
    }

    /**
     * @return ItemPrice
     */
    public function getWeekPrice(): ?ItemPrice
    {
        return $this->weekPrice;
    }

    /**
     * @param ItemPrice $weekPrice
     *
     * @return self
     */
    public function setWeekPrice(?ItemPrice $weekPrice): self
    {
        $this->weekPrice = $weekPrice;
        return $this;
    }

    /**
     * @return ItemPrice
     */
    public function getMonthPrice(): ?ItemPrice
    {
        return $this->monthPrice;
    }

    /**
     * @param ItemPrice $monthPrice
     *
     * @return self
     */
    public function setMonthPrice(?ItemPrice $monthPrice): self
    {
        $this->monthPrice = $monthPrice;
        return $this;
    }

    /**
     * @return ItemPrice
     */
    public function getAllTimePrice(): ?ItemPrice
    {
        return $this->allTimePrice;
    }

    /**
     * @param ItemPrice $allTimePrice
     *
     * @return self
     */
    public function setAllTimePrice(?ItemPrice $allTimePrice): self
    {
        $this->allTimePrice = $allTimePrice;
        return $this;
    }
}
