<?php

namespace App\Service\Marketplace\TM;

use App\Exception\TM\TMItemNotFound;
use App\Exception\TM\TMRequestFailed;
use App\Proto\TM\Instances\CS\CSTMItemInstancesProto;
use App\Proto\TM\Prices\CS\CSTMPricesProto;
use App\Proto\TM\Sells\CS\CSTMSellsProto;
use App\Service\Client\TM\TMCSClient;

class TMCSMarketplace
{
    public const INSTANCE_LINK = 'https://market.csgo.com/en/item/';

    /** @var TMCSClient */
    private $client;

    /**
     * TMCSMarketplace constructor.
     *
     * @param TMCSClient $client
     */
    public function __construct(TMCSClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $currency
     *
     * @return CSTMPricesProto
     *
     * @throws TMRequestFailed
     */
    public function retrieveCurrentPrices(string $currency)
    {
        return $this->client->getPrices($currency);
    }

    /**
     * @param string $hashName
     *
     * @return CSTMItemInstancesProto
     *
     * @throws TMRequestFailed
     * @throws TMItemNotFound
     */
    public function retrieveItemInstances(string $hashName)
    {
        return $this->client->getItemInstances($hashName);
    }

    /**
     * @param string $hashName
     *
     * @return CSTMSellsProto
     *
     * @throws TMItemNotFound
     * @throws TMRequestFailed
     */
    public function retrieveItemSells(string $hashName)
    {
        return $this->client->getItemSells($hashName);
    }
}
