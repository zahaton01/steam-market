<?php

namespace App\Proto\TM\Instances\CS;

use App\Proto\AbstractProto;

class CSTMItemInstanceProto extends AbstractProto
{
    /** @var string */
    private $hashName;
    /** @var string */
    private $instance;
    /** @var float */
    private $price;
    /** @var string */
    private $currency;
    /** @var integer */
    private $quantity;

    /**
     * @param null $data
     * @param array $params
     *
     * @return $this|mixed
     */
    public function init($data = null, array $params = [])
    {
        if (null !== $data && !$this->hasProto()) {
            $this->hashName = $data['market_hash_name'];
            $this->currency = $data['currency'] ?? null;

            $isDividedPrice = $params['divide_price'] ?? false;
            if ($isDividedPrice) {
                $this->price = $data['price'] / 100;
            } else {
                $this->price = $data['price'];
            }

            $this->quantity = $data['count'];
            $this->instance = $data['instance'];
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
     * @return string
     */
    public function getInstance(): ?string
    {
        return $this->instance;
    }

    /**
     * @param string $instance
     *
     * @return self
     */
    public function setInstance(?string $instance): self
    {
        $this->instance = $instance;
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
}
