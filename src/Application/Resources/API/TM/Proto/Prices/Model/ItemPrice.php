<?php

namespace App\Application\Resources\API\TM\Proto\Prices\Model;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ItemPrice
{
    /** @var string */
    private $hashName;
    /** @var float */
    private $price;

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
