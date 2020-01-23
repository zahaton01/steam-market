<?php

namespace App\Application\Config\Exchanger;

use App\Application\Config\ConfigInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ExchangerConfig implements ConfigInterface
{
    /** @var array */
    private $rates;

    /**
     * @param string $projectDir
     *
     * @return ConfigInterface
     */
    public function __invoke(string $projectDir): ConfigInterface
    {
        $this->rates = json_decode(file_get_contents("$projectDir/resources/tools/exchanger/exchange_rates.json"), true);

        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return ExchangerConfig::class;
    }

    /**
     * @return array
     */
    public function getRates(): array
    {
        return $this->rates;
    }

    /**
     * @param array $rates
     *
     * @return self
     */
    public function setRates(?array $rates): self
    {
        $this->rates = $rates;
        return $this;
    }
}