<?php

namespace App\Application\Config\Exchanger;

use App\Application\Config\ConfigInterface;
use App\Application\Exception\Config\ConfigInvokeFailed;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ExchangerConfig implements ConfigInterface
{
    /** @var array */
    private $rates;

    /**
     * @param array $params
     *
     * @return ConfigInterface
     *
     * @throws ConfigInvokeFailed
     */
    public function __invoke(array $params = []): ConfigInterface
    {
        if (!isset($params['project_dir']))
            throw new ConfigInvokeFailed('Missing project dir in params');

        $this->rates = json_decode(file_get_contents("{$params['project_dir']}/resources/config/tools/exchanger/exchange_rates.json"), true);

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