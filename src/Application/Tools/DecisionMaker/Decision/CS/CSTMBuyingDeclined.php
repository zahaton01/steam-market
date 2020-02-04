<?php

namespace App\Application\Tools\DecisionMaker\Decision\CS;

use App\Application\Tools\DecisionMaker\Decision\DecisionResultInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSTMBuyingDeclined implements DecisionResultInterface
{
    /** @var string */
    private $hashName;
    /** @var string */
    private $reason;
    /** @var string */
    private $instance;
    /** @var float */
    private $buyPrice;
    /** @var float */
    private $minSellPrice;

    /**
     * @return string
     */
    public function getHashName(): string
    {
        return $this->hashName;
    }

    /**
     * @param string $hashName
     *
     * @return self
     */
    public function setHashName(string $hashName)
    {
        $this->hashName = $hashName;
        return $this;
    }

    /**
     * @return string
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     *
     * @return self
     */
    public function setReason(?string $reason): self
    {
        $this->reason = $reason;
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
    public function getBuyPrice(): ?float
    {
        return $this->buyPrice;
    }

    /**
     * @param float $buyPrice
     *
     * @return self
     */
    public function setBuyPrice(?float $buyPrice): self
    {
        $this->buyPrice = $buyPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getMinSellPrice(): ?float
    {
        return $this->minSellPrice;
    }

    /**
     * @param float $minSellPrice
     *
     * @return self
     */
    public function setMinSellPrice(?float $minSellPrice): self
    {
        $this->minSellPrice = $minSellPrice;
        return $this;
    }
}
