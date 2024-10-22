<?php

namespace App\Application\Tools\Exchanger\Model;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ToCurrencyModel
{
    /** @var string */
    private $currency;

    /**
     * ToCurrencyModel constructor.
     * @param string $currency
     */
    public function __construct(string $currency)
    {
        $this->currency = $currency;
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
