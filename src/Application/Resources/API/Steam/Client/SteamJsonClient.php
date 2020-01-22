<?php

namespace App\Application\Resources\API\Steam\Client;

use App\Application\Exception\Client\BadResponseException;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;
use App\Application\Resources\API\Steam\Exception\SteamItemNotFound;
use App\Application\Resources\API\Steam\Exception\SteamRequestFailed;
use App\Application\Resources\API\Steam\Proto\PriceOverview\PriceOverviewProto;
use App\Application\Service\Client\JSON\JsonClient;

class SteamJsonClient extends JsonClient
{
    private const URL_PRICE_OVERVIEW = 'https://steamcommunity.com/market/priceoverview/';
    private const URL_PRICE_HISTORY = 'https://steamcommunity.com/market/pricehistory/';

    /**
     * @param string $hashName
     * @param int $currency
     * @param int $app
     *
     * @return PriceOverviewProto
     *
     * @throws SteamItemNotFound
     * @throws SteamRequestFailed
     */
    public function getPriceOverview(string $hashName, int $app, int $currency): PriceOverviewProto
    {
        try {
            $json = $this->getJson(self::URL_PRICE_OVERVIEW, [
                'market_hash_name' => $hashName,
                'currency' => $currency,
                'appid' => $app
            ]);

            $status = $json->getDecodedJson()['success'] ?? null;
            $data = $json->getDecodedJson();

            if (null === $status || false === $status || !isset($data['lowest_price']) || !isset($data['median_price']))
                throw new SteamItemNotFound("{$hashName} was not found on Steam");

            return new PriceOverviewProto($json);
        } catch (BadResponseException | MissingProtoFieldException $e) {
            throw new SteamRequestFailed($e->getMessage(), $e->getCode(), $e);
        }
    }
}
