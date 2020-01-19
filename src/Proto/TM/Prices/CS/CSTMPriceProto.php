<?php

namespace App\Proto\TM\Prices\CS;

use App\Proto\AbstractProto;

class CSTMPriceProto extends AbstractProto
{
    /** @var string */
    private $hashName;
    /** @var float */
    private $price;

    /**
     * @param null $data
     *
     * @return $this
     */
    public function init($data = null)
    {
        if (null !== $data) {
            $this->price = $data['price'];
            $this->hashName = $data['market_hash_name'];
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
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return self
     */
    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }
}