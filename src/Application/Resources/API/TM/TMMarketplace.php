<?php

namespace App\Application\Resources\API\TM;

use App\Application\Config\API\TM\TMConfig;
use App\Application\Config\ConfigResolver;
use App\Application\Exception\Config\ConfigInvokeFailed;
use App\Application\Exception\Config\ConfigNotFound;
use App\Application\Resources\API\TM\Client\TMCSJsonClient;
use App\Application\Resources\API\TM\Proto\Sells\TMPricingProto;
use App\Application\Resources\ApiResourceInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class TMMarketplace implements ApiResourceInterface
{
    /** @var TMCSJsonClient  */
    private $csJsonClient;
    /** @var array */
    private $config;

    /**
     * TMMarketplace constructor.
     * @param TMCSJsonClient $csJsonClient
     * @param ConfigResolver $config
     *
     * @throws ConfigInvokeFailed
     * @throws ConfigNotFound
     */
    public function __construct(TMCSJsonClient $csJsonClient, ConfigResolver $config)
    {
        $this->csJsonClient = $csJsonClient;
        $this->config = $config->resolve(TMConfig::class)->getConfig();

        $this->csJsonClient->setApiKey($this->config['api_keys']['cs']);
    }

    /**
     * @param string $currency
     *
     * @return Proto\Prices\PricesProto
     *
     * @throws Exception\TMRequestFailed
     */
    public function getCsPrices(string $currency)
    {
        return $this->csJsonClient->getPrices($currency);
    }

    /**
     * @param string $hashName
     *
     * @return Proto\ItemInstances\CS\ItemInstancesProto
     *
     * @throws Exception\TMItemNotFound
     * @throws Exception\TMRequestFailed
     */
    public function getCsItemInstances(string $hashName)
    {
        return $this->csJsonClient->getItemInstances($hashName);
    }

    /**
     * @param array $hashNames
     *
     * @return Proto\Sells\TMPricingProto
     *
     * @throws Exception\TMItemNotFound
     * @throws Exception\TMRequestFailed
     */
    public function getPricing(array $hashNames): TMPricingProto
    {
        return $this->csJsonClient->getPricing($hashNames);
    }

    /**
     * @param string $hashName
     * @param float $price
     *
     * @return Proto\Buy\CS\BoughtProto
     * @throws Exception\TMRequestFailed
     */
    public function buyCs(string $hashName, float $price)
    {
        return $this->csJsonClient->buy($hashName, $price, uniqid());
    }

    /**
     * @return array
     */
    public function getConfig(): ?array
    {
        return $this->config;
    }
}
