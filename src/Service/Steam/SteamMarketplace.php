<?php

namespace App\Service\Steam;

use App\Exception\Steam\SteamItemNotFound;
use App\Exception\Steam\SteamRequestFailed;
use App\Model\Currency;
use App\Model\Steam\CSGO\CSGOItem;
use App\Model\Steam\SteamApp;
use App\Model\Steam\SteamCurrency;
use App\Service\TextService;

class SteamMarketplace
{
    public const LISTING_URL = 'https://steamcommunity.com/market/listings/';

    /** @var SteamMarketplaceClient  */
    private $client;

    /**
     * SteamMarketplace constructor.
     * @param SteamMarketplaceClient $steamMarketplaceClient
     */
    public function __construct(SteamMarketplaceClient $steamMarketplaceClient)
    {
        $this->client = $steamMarketplaceClient;
    }

    /**
     * @param string $itemName
     * @param int $currency
     *
     * @return CSGOItem
     *
     * @throws SteamItemNotFound
     * @throws SteamRequestFailed
     */
    public function getCsGoItemMetaData(string $itemName, int $currency = SteamCurrency::RUB)
    {
        $json = $this->client->getJsonItemMetaData($itemName, SteamApp::CS_GO_APP_ID, $currency);

        $CSGOItem = new CSGOItem();
        $CSGOItem
            ->setSteamCurrency($currency)
            ->setCurrency(Currency::getFromSteamCurrency($currency))
            ->setLowestPrice(TextService::getFloatFromSteamResponse($json['lowest_price']))
            ->setMedianPrice(TextService::getFloatFromSteamResponse($json['median_price']))
            ->setMarketplaceUrl(self::LISTING_URL . SteamApp::CS_GO_APP_ID . "/{$itemName}");

        return $CSGOItem;
    }
}