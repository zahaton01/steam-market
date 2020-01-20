<?php

namespace App\Service\Exchange;

use App\Exception\Exchange\BadExchangeRequest;
use App\Exception\Exchange\ExchangeRateNotExist;
use App\Model\Currency;
use App\Service\Exchange\Model\FromCurrencyModel;
use App\Service\Exchange\Model\ToCurrencyModel;

class Exchanger
{
    /** @var array */
    private $rates;
    /** @var FromCurrencyModel */
    private $from;
    /** @var ToCurrencyModel */
    private $to;

    /**
     * Exchanger constructor.
     */
    public function __construct()
    {
        $this->from = null;
        $this->to = null;

        $this->rates = [
            Currency::UAH => [
                Currency::RUB => $_ENV['UAH_RUB_EXCHANGE_RATE']
            ]
        ];
    }

    /**
     * @param string $currency
     * @param float $amount
     *
     * @return Exchanger
     */
    public function from(string $currency, float $amount): Exchanger
    {
        $this->from = new FromCurrencyModel($currency, $amount);

        return $this;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function to(string $currency): Exchanger
    {
        $this->to = new ToCurrencyModel($currency);

        return $this;
    }

    /**
     * @return float
     *
     * @throws ExchangeRateNotExist
     * @throws BadExchangeRequest
     */
    public function exchange(): float
    {
        if (null === $this->to || null === $this->from) {
            throw new BadExchangeRequest("You did not specify from or to currency");
        }

        if (!in_array($this->from->getCurrency(), $this->rates) ||
            !in_array($this->to->getCurrency(), $this->rates[$this->from->getCurrency()])
        ) {
            throw new ExchangeRateNotExist("There is no rate to exchange from {$this->from->getCurrency()} to {$this->to->getCurrency()}");
        }

        $rate = $this->rates[$this->from->getCurrency()][$this->to->getCurrency()];

        return $this->from->getAmount() * $rate;
    }
}
