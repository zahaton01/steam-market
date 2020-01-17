<?php

namespace App\Model\TMMarketplace\CSGO;

class TMCSGOItemCurrentInstance extends TMCSGOItemCurrentPrice
{
    /** @var string */
    protected $instance;
    /** @var float */
    protected $buyOrder;
    /** @var float */
    protected $medianPrice;
    /** @var string */
    protected $link;

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
    public function getBuyOrder(): ?float
    {
        return $this->buyOrder;
    }

    /**
     * @param float $buyOrder
     *
     * @return self
     */
    public function setBuyOrder(?float $buyOrder): self
    {
        $this->buyOrder = $buyOrder;
        return $this;
    }

    /**
     * @return float
     */
    public function getMedianPrice(): ?float
    {
        return $this->medianPrice;
    }

    /**
     * @param float $medianPrice
     *
     * @return self
     */
    public function setMedianPrice(?float $medianPrice): self
    {
        $this->medianPrice = $medianPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return self
     */
    public function setLink(?string $link): self
    {
        $this->link = $link;
        return $this;
    }
}
