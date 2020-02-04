<?php

namespace App\Application\Tools\DecisionMaker\Decision\CS;

use App\Application\Tools\DecisionMaker\Decision\DecisionResultInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSTMBuyingApproved implements DecisionResultInterface
{
    /** @var string */
    private $hashName;
    /** @var string */
    private $instance;
    /** @var float */
    private $minSellPrice;
    /** @var float */
    private $buyPrice;

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
}
