<?php

namespace App\Application\Resources\API\Steam;

use App\Application\Resources\ApiResourceInterface;
use App\Application\Resources\API\Steam\Client\SteamJsonClient;
use App\Application\Resources\API\Steam\Model\SteamCurrency;
use App\Application\Resources\API\Steam\Proto\PriceOverview\PriceOverviewProto;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class SteamMarketplace implements ApiResourceInterface
{
    private $jsonClient;

    /**
     * SteamMarketplace constructor.
     * @param SteamJsonClient $client
     */
    public function __construct(SteamJsonClient $client)
    {
        $this->jsonClient = $client;
    }

    /**
     * @param string $hashName
     * @param int $app
     * @param string $currency
     *
     * @return PriceOverviewProto
     *
     * @throws Exception\SteamItemNotFound
     * @throws Exception\SteamRequestFailed
     */
    public function getPriceOverview(string $hashName, int $app, string $currency): PriceOverviewProto
    {
        return $this->jsonClient->getPriceOverview($hashName, $app, SteamCurrency::fromApp($currency));
    }
}
