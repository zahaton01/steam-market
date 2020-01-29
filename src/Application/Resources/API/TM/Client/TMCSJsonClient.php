<?php

namespace App\Application\Resources\API\TM\Client;

use App\Application\Exception\Client\BadResponseException;
use App\Application\Resources\API\TM\Exception\TMItemNotFound;
use App\Application\Resources\API\TM\Exception\TMRequestFailed;
use App\Application\Resources\API\TM\Proto\ItemInstances\CS\ItemInstancesProto;
use App\Application\Resources\API\TM\Proto\Prices\PricesProto;
use App\Application\Resources\API\TM\Proto\Sells\TMPricingProto;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;
use App\Application\Service\Client\JSON\JsonClient;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class TMCSJsonClient extends JsonClient
{
    private const URL_PRICES = 'https://market.csgo.com/api/v2/prices/';
    private const URL_ITEM_INSTANCES = 'https://market.csgo.com/api/v2/search-item-by-hash-name';
    private const URL_PRICING = 'https://market.csgo.com/api/v2/get-list-items-info';

    /** @var string */
    private $apiKey;

    /**
     * @param string $currency
     *
     * @return PricesProto
     *
     * @throws TMRequestFailed
     */
    public function getPrices(string $currency): PricesProto
    {
        try {
            $json = $this->getJson(self::URL_PRICES . "$currency.json");
            $status = $json->getDecodedJson()['success'] ?? null;

            if (null === $status || false === $status)
                throw new TMRequestFailed("Response status is false");

            return new PricesProto($json);
        } catch (BadResponseException | MissingProtoFieldException $e) {
            throw new TMRequestFailed($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $hashName
     *
     * @return ItemInstancesProto
     *
     * @throws TMItemNotFound
     * @throws TMRequestFailed
     */
    public function getItemInstances(string $hashName): ItemInstancesProto
    {
        try {
            $json = $this->getJson(self::URL_ITEM_INSTANCES, [
                'key' => $this->apiKey,
                'hash_name' => $hashName
            ]);
            $status = $json->getDecodedJson()['success'] ?? null;

            if (null === $status || false === $status)
                throw new TMItemNotFound("$hashName was not found on TM Marketplace");

            return new ItemInstancesProto($json);
        } catch (BadResponseException | MissingProtoFieldException $e) {
            throw new TMRequestFailed($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param array $hashNames
     *
     * @return TMPricingProto
     *
     * @throws TMItemNotFound
     * @throws TMRequestFailed
     */
    public function getPricing(array $hashNames): TMPricingProto
    {
        try {
            $json = $this->getJson(self::URL_PRICING, [
                'key' => $this->apiKey,
                'list_hash_name[]' => $hashNames
            ]);
            $status = $json->getDecodedJson()['success'] ?? null;

            if (null === $status || false === $status)
                throw new TMItemNotFound("None were found on TM Marketplace");

            return new TMPricingProto($json);
        } catch (BadResponseException | MissingProtoFieldException $e) {
            throw new TMRequestFailed($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $key
     */
    public function setApiKey(string $key)
    {
        $this->apiKey = $key;
    }
}
