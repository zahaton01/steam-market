<?php

namespace App\Proto\BP\ItemPrice;

use App\Proto\AbstractProto;
use App\Proto\JSONProto;

class ItemPriceProto extends AbstractProto
{
    /** @var string */
    private $currency;
    /** @var float */
    private $average;
    /** @var string */
    private $median;
    /** @var float */
    private $lowestPrice;
    /** @var float */
    private $highestPrice;

    /**
     * ItemPriceProto constructor.
     * @param JSONProto|null $proto
     */
    public function __construct(JSONProto $proto = null)
    {
        parent::__construct($proto);

        if ($this->hasProto()) {
            $this->init();
        }
    }

    /**
     * @param null $data
     * @param array $params
     *
     * @return $this|mixed
     */
    public function init($data = null, array $params = [])
    {
        if ($this->hasProto()) {
            $data = $this->getProto()->getDecodedJson();

            $this->currency = $data['currency'];
            $this->average = $data['average_price'];
            $this->median = $data['median_price'];
            $this->lowestPrice = $data['lowest_price'];
            $this->highestPrice = $data['highest_price'];
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return self
     */
    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;
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
     * @return string
     */
    public function getMedian(): ?string
    {
        return $this->median;
    }

    /**
     * @param string $median
     *
     * @return self
     */
    public function setMedian(?string $median): self
    {
        $this->median = $median;
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
     * @param float $lowest
     *
     * @return self
     */
    public function setLowestPrice(?float $lowest): self
    {
        $this->lowestPrice = $lowest;
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
     * @param float $highest
     *
     * @return self
     */
    public function setHighestPrice(?float $highest): self
    {
        $this->highestPrice = $highest;
        return $this;
    }
}
