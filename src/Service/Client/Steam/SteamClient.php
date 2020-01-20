<?php

namespace App\Service\Client\Steam;

use App\Exception\BadResponseException;
use App\Exception\Steam\SteamItemNotFound;
use App\Exception\Steam\SteamRequestFailed;
use App\Model\Steam\SteamApp;
use App\Proto\Steam\CS\CSSteamPriceOverviewProto;
use App\Service\Client\AbstractClient;

class SteamClient extends AbstractClient
{
    private const URL_PRICE_OVERVIEW = 'https://steamcommunity.com/market/priceoverview/';
    private const URL_PRICE_HISTORY = 'https://steamcommunity.com/market/pricehistory/';

    /**
     * @param string $hashName
     * @param int $currency
     * @param int $app
     *
     * @return CSSteamPriceOverviewProto
     *
     * @throws SteamItemNotFound
     * @throws SteamRequestFailed
     */
    public function getCSPriceOverview(string $hashName, int $currency, int $app = SteamApp::CS): CSSteamPriceOverviewProto
    {
        try {
            $json = $this->getJson(self::URL_PRICE_OVERVIEW, [
                'market_hash_name' => $hashName,
                'currency' => $currency,
                'appid' => $app
            ]);

            $status = $json->getDecodedJson()['success'] ?? null;

            if (null === $status || false === $status)
                throw new SteamItemNotFound("{$hashName} was not found on Steam");

            return new CSSteamPriceOverviewProto($json);
        } catch (BadResponseException $e) {
            throw new SteamRequestFailed($e->getMessage());
        }
    }
}
