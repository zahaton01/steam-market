<?php

namespace App\Service\Steam;

use App\Exception\Steam\SteamItemNotFound;
use App\Exception\Steam\SteamRequestFailed;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class SteamMarketplaceClient
{
    public const GET_JSON_ITEM_OVERVIEW_URL = 'https://steamcommunity.com/market/priceoverview/';

    /** @var Client  */
    protected $client;

    /**
     * SteamMarketplaceClient constructor.
     */
    function __construct()
    {
        $this->client = new Client([
            'cookies' => true,
        ]);
    }

    /**
     * @param string $itemName
     * @param int $app
     * @param int $currency
     *
     * @return array
     *
     * @throws SteamItemNotFound
     * @throws SteamRequestFailed
     */
    public function getJsonItemMetaData(string $itemName, int $app, int $currency)
    {
        try {
            $response = $this->client->request('GET', self::GET_JSON_ITEM_OVERVIEW_URL . "?currency={$currency}&appid={$app}&market_hash_name={$itemName}");
            $jsonResponse = json_decode($response->getBody()->getContents(), true);

            if (!isset($jsonResponse['success']) || !$jsonResponse['success'])
                throw new SteamItemNotFound();

            return $jsonResponse;
        } catch (ClientException | ServerException $e) {
            throw new SteamRequestFailed();
        }
    }
}