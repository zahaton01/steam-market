<?php

namespace App\Application\Resources\API\TM;

use App\Application\Config\ConfigResolver;
use App\Application\Resources\API\TM\Client\TMCSJsonClient;
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
     */
    public function __construct(TMCSJsonClient $csJsonClient, ConfigResolver $config)
    {
        $this->csJsonClient = $csJsonClient;
        $this->config = $config->getTm();

        $this->csJsonClient->setApiKey($this->config['api_keys']['cs']);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return TMMarketplace::class;
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
     * @return array
     */
    public function getConfig(): ?array
    {
        return $this->config;
    }
}
