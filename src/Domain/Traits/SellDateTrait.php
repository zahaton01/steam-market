<?php

namespace App\Domain\Traits;

trait SellDateTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sell_date", type="datetime", nullable=true)
     */
    private $sellDate;

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
}
