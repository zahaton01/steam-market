<?php

namespace App\Application\Resources\API\TM\Proto\Sells\Model;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class TMSell
{
    /** @var \DateTime */
    private $sellDate;
    /** @var float */
    private $price;

    /**
     * @return \DateTime
     */
    public function getSellDate(): ?\DateTime
    {
        return $this->sellDate;
    }

    /**
     * @param \DateTime $sellDate
     *
     * @return self
     */
    public function setSellDate(?\DateTime $sellDate): self
    {
        $this->sellDate = $sellDate;
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