<?php

namespace App\Service\Steam;

use App\Exception\Steam\SteamItemNotFound;
use App\Exception\Steam\SteamRequestFailed;
use App\Model\Steam\SteamApp;
use App\Model\Steam\SteamCurrency;
use App\Proto\Steam\CS\CSSteamPriceOverviewProto;
use App\Service\Client\Steam\SteamClient;

class SteamMarketplace
{
    public const LISTING_URL = 'https://steamcommunity.com/market/listings/';

    /** @var SteamClient  */
    private $client;

    /**
     * SteamMarketplace constructor.
     * @param SteamClient $steamClient
     */
    public function __construct(SteamClient $steamClient)
    {
        $this->client = $steamClient;
    }

    /**
     * @param string $hashName
     * @param string $currency
     *
     * @return CSSteamPriceOverviewProto
     *
     * @throws SteamItemNotFound
     * @throws SteamRequestFailed
     */
    public function retrieveCSPriceOverview(string $hashName, string $currency): CSSteamPriceOverviewProto
    {
        return $this->client->getCSPriceOverview($hashName, SteamCurrency::fromApp($currency));
    }

    /**
     * @param string $itemName
     *
     * @return array
     *
     * @throws SteamItemNotFound
     * @throws SteamRequestFailed
     */
    public function retrievePriceHistory(string $itemName)
    {
        return $this->client->retrievePriceHistory($itemName, SteamApp::CS_GO_APP_ID);
    }
}
