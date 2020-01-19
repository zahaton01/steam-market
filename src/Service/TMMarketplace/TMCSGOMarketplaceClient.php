<?php

namespace App\Service\TMMarketplace;

use App\Exception\TM\TMItemNotFound;
use App\Exception\TM\TMRequestFailed;
use App\Model\Currency;
use App\Model\TMMarketplace\CSGO\TMCSGOItemCurrentInstance;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class TMCSGOMarketplaceClient
{
    public const CURRENT_PRICES_URL = 'https://market.csgo.com/api/v2/prices/';
    public const CURRENT_INSTANCES_URL = 'https://market.csgo.com/api/v2/prices/class_instance/';

    /** @var mixed  */
    private $apiKey;

    /** @var Client  */
    private $client;

    /**
     * TMCSGOMarketplaceClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'cookies' => true,
        ]);

        $this->apiKey = $_ENV['CS_GO_TM_MARKETPLACE_API_KEY'];
    }

    /**
     * @param string $currency
     *
     * @return array
     *
     * @throws TMRequestFailed
     */
    public function retrieveCurrentPrices(string $currency = Currency::RUB)
    {
        try {
            $response = $this->client->request('GET', self::CURRENT_PRICES_URL . "$currency.json");
            $json = json_decode($response->getBody()->getContents(), true);

            if (!isset($json['success']) || $json['success'] !== true || !isset($json['items']) || empty($json['items']))
                throw new TMRequestFailed();

            return $json;
        } catch (ClientException | ServerException $e) {
            throw new TMRequestFailed($e->getMessage());
        }
    }

    /**
     * @param string $currency
     *
     * @return mixed
     *
     * @throws TMRequestFailed
     */
    public function retrieveCurrentInstances($currency = Currency::RUB)
    {
        try {
            $response = $this->client->request('GET', self::CURRENT_INSTANCES_URL . "$currency.json");
            $json = json_decode($response->getBody()->getContents(), true);

            if (!isset($json['success']) || $json['success'] !== true || !isset($json['items']) || empty($json['items']))
                throw new TMRequestFailed();

            return $json;
        } catch (ClientException | ServerException $e) {
            throw new TMRequestFailed($e->getMessage());
        }
    }

    /**
     * @param string $itemName
     *
     * @return mixed
     *
     * @throws TMRequestFailed
     * @throws TMItemNotFound
     */
    public function retrieveInstance(string $itemName)
    {
        try {
            $response = $this->client->request('GET', "https://market.csgo.com/api/v2/search-item-by-hash-name?key={$this->apiKey}&hash_name=$itemName");
            $json = json_decode($response->getBody()->getContents(), true);

            if (!isset($json['success']) || $json['success'] !== true || !isset($json['data']) || empty($json['data']))
                throw new TMItemNotFound("$itemName was not found");

            return $json;
        } catch (ClientException | ServerException $e) {
            throw new TMRequestFailed($e->getMessage());
        }
    }

    /**
     * @param string $itemName
     *
     * @return mixed
     *
     * @throws TMRequestFailed
     * @throws TMItemNotFound
     */
    public function retrieveItemDetails(string $itemName)
    {
        try {
            $response = $this->client->request('GET', "https://market.csgo.com/api/v2/get-list-items-info?key={$this->apiKey}&list_hash_name[]={$itemName}");
            $json = json_decode($response->getBody()->getContents(), true);

            if (!isset($json['success']) || $json['success'] !== true || !isset($json['data']) || empty($json['data']))
                throw new TMItemNotFound("$itemName was not found");

            return $json;
        } catch (ClientException | ServerException $e) {
            throw new TMRequestFailed($e->getMessage());
        }
    }
}
