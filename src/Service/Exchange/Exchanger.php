<?php

namespace App\Service\Exchange;

use App\Model\Currency;

class Exchanger
{
    /** @var float */
    private $uahRubExchangeRate;

    /** @var string */
    private $from;
    /** @var string */
    private $to;

    /**
     * Exchanger constructor.
     */
    public function __construct()
    {
        $this->uahRubExchangeRate = (float) $_ENV['UAH_RUB_EXCHANGE_RATE'];
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function from(string $currency)
    {
        $this->from = $currency;

        return $this;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function to(string $currency)
    {
        $this->to = $currency;

        return $this;
    }

    /**
     * @param float $amount
     *
     * @return float|int
     */
    public function amount(float $amount)
    {
        $rate = $this->getExchangeRate();

        if (null === $rate) {
            return $amount;
        }

        return $amount * $rate;
    }

    /**
     * @return float|null
     */
    private function getExchangeRate()
    {
        if ($this->from === Currency::UAH && $this->to === Currency::RUB) {
            return $this->uahRubExchangeRate;
        }

        return null;
    }
}