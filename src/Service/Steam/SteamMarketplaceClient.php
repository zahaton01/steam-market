<?php

namespace App\Service\Steam;

use App\Exception\ProxyException;
use App\Exception\Steam\SteamItemNotFound;
use App\Exception\Steam\SteamRequestFailed;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class SteamMarketplaceClient
{
    public const GET_JSON_ITEM_OVERVIEW_URL = 'https://steamcommunity.com/market/priceoverview/';
    public const PRICE_HISTORY_URL = 'https://steamcommunity.com/market/pricehistory/';

    /** @var Client  */
    protected $client;

    /**
     * SteamMarketplaceClient constructor.
     */
    function __construct()
    {
        $this->client = new Client([
            'cookies' => true
        ]);
    }

    /**
     * @param string $itemName
     * @param int $app
     *
     * @return array
     *
     * @throws SteamItemNotFound
     * @throws SteamRequestFailed
     */
    public function retrievePriceHistory(string $itemName, int $app)
    {
        try {
            $response = $this->client->request('GET', self::PRICE_HISTORY_URL . "?appid={$app}&market_hash_name={$itemName}");
            $jsonResponse = json_decode($response->getBody()->getContents(), true);

            if (!isset($jsonResponse) || null === $jsonResponse)
                throw new SteamRequestFailed();

            if (!isset($jsonResponse['success']) || !$jsonResponse['success'])
                throw new SteamItemNotFound("$itemName was not found");

            return $jsonResponse;
        } catch (ClientException | ServerException $e) {
            throw new SteamRequestFailed($e->getMessage());
        }
    }

    /**
     * @param string $itemName
     * @param int $app
     * @param int $currency
     * @param array $proxies
     *
     * @return array
     *
     * @throws SteamItemNotFound
     * @throws SteamRequestFailed
     */
    public function getJsonItemMetaData(string $itemName, int $app, int $currency, array $proxies = [])
    {
        try {
            if (!empty($proxies)) {
                foreach ($proxies as $proxy) {
                    try {
                        $response = $this->client->request('GET', self::GET_JSON_ITEM_OVERVIEW_URL . "?currency={$currency}&appid={$app}&market_hash_name={$itemName}", [
                            'proxy' => $proxy
                        ]);

                        $jsonResponse = json_decode($response->getBody()->getContents(), true);

                        if (null === $jsonResponse) {
                            throw new ProxyException();
                        }

                    } catch (\Exception $e) {
                        continue;
                    }
                }
            } else { // request without proxies
                $response = $this->client->request('GET', self::GET_JSON_ITEM_OVERVIEW_URL . "?currency={$currency}&appid={$app}&market_hash_name={$itemName}");
                $jsonResponse = json_decode($response->getBody()->getContents(), true);
            }

            if (!isset($jsonResponse) || null === $jsonResponse)
                throw new SteamRequestFailed();

            if (!isset($jsonResponse['success']) || !$jsonResponse['success'] || !isset($jsonResponse['lowest_price']) || !isset($jsonResponse['median_price']))
                throw new SteamItemNotFound("$itemName was not found");

            return $jsonResponse;
        } catch (ClientException | ServerException $e) {
            throw new SteamRequestFailed($e->getMessage());
        }
    }
}
