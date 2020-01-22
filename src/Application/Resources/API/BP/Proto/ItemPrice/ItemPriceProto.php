<?php

namespace App\Application\Resources\API\BP\Proto\ItemPrice;

use App\Application\Resources\Proto\AbstractProto;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;

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
     * @return $this
     *
     * @throws MissingProtoFieldException
     */
    public function __invoke()
    {
        if ($this->validate()) {
            $json = $this->getProto()->getDecodedJson();

            $this->currency = $json['currency'] ?? null;
            $this->average = $json['average_price'];
            $this->lowestPrice = $json['lowest_price'];
            $this->highestPrice = $json['highest_price'];
            $this->median = $json['median_price'] ?? null;
        }

        return $this;
    }

    /**
     * @return bool
     *
     * @throws MissingProtoFieldException
     */
    public function validate(): bool
    {
        $json = $this->getProto()->getDecodedJson();

        if (!isset($json['average_price']))
            throw new MissingProtoFieldException('average_price is missing');

        if (!isset($json['lowest_price']))
            throw new MissingProtoFieldException('average_price is missing');

        if (!isset($json['highest_price']))
            throw new MissingProtoFieldException('average_price is missing');

        return true;
    }

    /**
     * @return string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getAverage(): ?float
    {
        return $this->average;
    }

    /**
     * @return string
     */
    public function getMedian(): ?string
    {
        return $this->median;
    }

    /**
     * @return float
     */
    public function getLowestPrice(): ?float
    {
        return $this->lowestPrice;
    }

    /**
     * @return float
     */
    public function getHighestPrice(): ?float
    {
        return $this->highestPrice;
    }
}
