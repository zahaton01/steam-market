<?php

namespace App\Application\Tools\Exchanger\Model;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class FromCurrencyModel
{
    /** @var string */
    private $currency;
    /** @var float */
    private $amount;

    /**
     * FromCurrencyModel constructor.
     * @param string $currency
     * @param float $amount
     */
    public function __construct(string $currency, float $amount)
    {
        $this->currency = $currency;
        $this->amount = $amount;
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

    /**
     * @return float
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return self
     */
    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }
}
