<?php

namespace App\Service\Client\TM;

use App\Exception\BadResponseException;
use App\Exception\TM\TMItemNotFound;
use App\Exception\TM\TMRequestFailed;
use App\Proto\TM\Instances\CS\CSTMItemInstancesProto;
use App\Proto\TM\Prices\CS\CSTMPricesProto;
use App\Proto\TM\Sells\CS\CSTMSellsProto;
use App\Service\Client\AbstractClient;

class TMCSClient extends AbstractClient
{
    private const URL_PRICES = 'https://market.csgo.com/api/v2/prices/';
    private const URL_ITEM_INSTANCES = 'https://market.csgo.com/api/v2/search-item-by-hash-name';
    private const URL_ITEM_SELLS_HISTORY = 'https://market.csgo.com/api/v2/get-list-items-info';

    /** @var string */
    private $csApiKey;

    /**
     * TMClient constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->csApiKey = $_ENV['CS_TM_API_KEY'];
    }

    /**
     * @param string $currency
     *
     * @return CSTMPricesProto
     *
     * @throws TMRequestFailed
     */
    public function getPrices(string $currency): CSTMPricesProto
    {
        try {
            $json = $this->getJson(self::URL_PRICES . "$currency.json");
            $status = $json->getDecodedJson()['success'] ?? null;

            if (null === $status || false === $status)
                throw new TMRequestFailed("Response status is false");

            return new CSTMPricesProto($json);
        } catch (BadResponseException $e) {
            throw new TMRequestFailed($e->getMessage());
        }
    }

    /**
     * @param string $hashName
     *
     * @return CSTMItemInstancesProto
     *
     * @throws TMItemNotFound
     * @throws TMRequestFailed
     */
    public function getItemInstances(string $hashName): CSTMItemInstancesProto
    {
        try {
            $json = $this->getJson(self::URL_ITEM_INSTANCES, [
                'key' => $this->csApiKey,
                'hash_name' => $hashName
            ]);
            $status = $json->getDecodedJson()['success'] ?? null;

            if (null === $status || false === $status)
                throw new TMItemNotFound("$hashName was not found on TM Marketplace");

            return new CSTMItemInstancesProto($json);
        } catch (BadResponseException $e) {
            throw new TMRequestFailed($e->getMessage());
        }
    }

    /**
     * @param string $hashName
     *
     * @return CSTMSellsProto
     *
     * @throws TMItemNotFound
     * @throws TMRequestFailed
     * @throws \Exception
     */
    public function getItemSells(string $hashName): CSTMSellsProto
    {
        try {
            $json = $this->getJson(self::URL_ITEM_SELLS_HISTORY, [
                'key' => $this->csApiKey,
                'list_hash_name[]' => $hashName
            ]);
            $status = $json->getDecodedJson()['success'] ?? null;

            if (null === $status || false === $status)
                throw new TMItemNotFound("$hashName was not found on TM Marketplace");

            return new CSTMSellsProto($json);
        } catch (BadResponseException $e) {
            throw new TMRequestFailed($e->getMessage());
        }
    }
}
