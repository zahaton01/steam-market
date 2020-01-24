<?php

namespace App\Application\Tools\Exchanger;

use App\Application\Config\ConfigResolver;
use App\Application\Config\Exchanger\ExchangerConfig;
use App\Application\Exception\Config\ConfigInvokeFailed;
use App\Application\Exception\Config\ConfigNotFound;
use App\Application\Model\Currency;
use App\Application\Tools\Exchanger\Exception\BadExchangeRequest;
use App\Application\Tools\Exchanger\Exception\ExchangeRateNotExist;
use App\Application\Tools\Exchanger\Model\FromCurrencyModel;
use App\Application\Tools\Exchanger\Model\ToCurrencyModel;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
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
     * @param ConfigResolver $config
     *
     * @throws ConfigNotFound
     * @throws ConfigInvokeFailed
     */
    public function __construct(ConfigResolver $config)
    {
        $this->rates = $config->resolve(ExchangerConfig::class)->getRates();
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
