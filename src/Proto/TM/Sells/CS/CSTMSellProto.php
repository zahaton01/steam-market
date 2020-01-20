<?php

namespace App\Proto\TM\Sells\CS;

use App\Proto\AbstractProto;
use App\Proto\JSONProto;

class CSTMSellProto extends AbstractProto
{
    /** @var \DateTime */
    private $sellDate;
    /** @var float */
    private $price;

    /**
     * @param null $data
     * @param array $params
     *
     * @return mixed|void
     *
     * @throws \Exception
     */
    public function init($data = null, array $params = [])
    {
        if (null !== $data && !$this->hasProto()) {
            $this->price = $data[1];
            $this->sellDate = (new \DateTime())->setTimestamp($data[0]);
        }

        return $this;
    }

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
