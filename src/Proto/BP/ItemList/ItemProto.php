<?php

namespace App\Proto\BP\ItemList;

use App\Proto\AbstractProto;

class ItemProto extends AbstractProto
{
    private const DAY = '24_hours';
    private const WEEK = '7_days';
    private const MONTH = '30_days';
    private const ALL = 'all_time';

    /** @var string */
    private $hashName;
    /** @var ItemPriceProto */
    private $dayPrice;
    /** @var ItemPriceProto */
    private $weekPrice;
    /** @var ItemPriceProto */
    private $monthPrice;
    /** @var ItemPriceProto */
    private $allTimePrice;

    /**
     * @param null $data
     * @param array $params
     *
     * @return $this|mixed
     */
    public function init($data = null, array $params = [])
    {
        if (null !== $data && !$this->hasProto()) {
            $this->hashName = $data['name'];

            if (isset($data['price'])) {
                foreach ($data['price'] as $key => $pricing) {
                    if (
                        $key === self::DAY ||
                        $key === self::WEEK ||
                        $key === self::MONTH ||
                        $key === self::ALL
                    ) {
                        $priceProto = new ItemPriceProto();
                        $priceProto
                            ->setAverage($pricing['average'])
                            ->setHighestPrice($pricing['highest_price'])
                            ->setLowestPrice($pricing['lowest_price'])
                            ->setMedian($pricing['median'])
                            ->setSold((int) $pricing['sold']);

                        switch ($key) {
                            case self::DAY:
                                $this->dayPrice = $priceProto;
                                break;
                            case self::WEEK:
                                $this->weekPrice = $priceProto;
                                break;
                            case self::MONTH:
                                $this->monthPrice = $priceProto;
                                break;
                            case self::ALL:
                                $this->allTimePrice = $priceProto;
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
        }

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

    /**
     * @return ItemPriceProto
     */
    public function getDayPrice(): ?ItemPriceProto
    {
        return $this->dayPrice;
    }

    /**
     * @param ItemPriceProto $dayPrice
     *
     * @return self
     */
    public function setDayPrice(?ItemPriceProto $dayPrice): self
    {
        $this->dayPrice = $dayPrice;
        return $this;
    }

    /**
     * @return ItemPriceProto
     */
    public function getWeekPrice(): ?ItemPriceProto
    {
        return $this->weekPrice;
    }

    /**
     * @param ItemPriceProto $weekPrice
     *
     * @return self
     */
    public function setWeekPrice(?ItemPriceProto $weekPrice): self
    {
        $this->weekPrice = $weekPrice;
        return $this;
    }

    /**
     * @return ItemPriceProto
     */
    public function getMonthPrice(): ?ItemPriceProto
    {
        return $this->monthPrice;
    }

    /**
     * @param ItemPriceProto $monthPrice
     *
     * @return self
     */
    public function setMonthPrice(?ItemPriceProto $monthPrice): self
    {
        $this->monthPrice = $monthPrice;
        return $this;
    }

    /**
     * @return ItemPriceProto
     */
    public function getAllTimePrice(): ?ItemPriceProto
    {
        return $this->allTimePrice;
    }

    /**
     * @param ItemPriceProto $allTimePrice
     *
     * @return self
     */
    public function setAllTimePrice(?ItemPriceProto $allTimePrice): self
    {
        $this->allTimePrice = $allTimePrice;
        return $this;
    }
}
