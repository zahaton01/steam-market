<?php

namespace App\Application\Resources\API\BP\Client;

use App\Application\Exception\Client\BadResponseException;
use App\Application\Resources\API\BP\Exception\BPLimitExceed;
use App\Application\Resources\API\BP\Exception\BPRequestFailed;
use App\Application\Resources\API\BP\Proto\ItemList\ItemListProto;
use App\Application\Resources\API\BP\Proto\ItemPrice\ItemPriceProto;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;
use App\Application\Service\Client\JSON\JsonClient;

class BPJsonClient extends JsonClient
{
    private const URL_LIST = 'http://csgobackpack.net/api/GetItemsList/v2/';
    private const URL_GET_PRICE = 'http://csgobackpack.net/api/GetItemPrice/';

    /**
     * @param string $currency
     *
     * @return ItemListProto
     *
     * @throws BPRequestFailed
     */
    public function getItemList(string $currency): ItemListProto
    {
        try {
            $json = $this->getJson(self::URL_LIST, [
                'currency' => $currency
            ]);

            $status = $json->getDecodedJson()['success'] ?? null;

            if (null === $status || false === $status)
                throw new BPRequestFailed("Response status is false");

            return new ItemListProto($json);
        } catch (BadResponseException | MissingProtoFieldException $e) {
            throw new BPRequestFailed($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $hashName
     * @param string $currency
     * @param int $lastDays
     *
     * @return ItemPriceProto
     *
     * @throws BPLimitExceed
     * @throws BPRequestFailed
     */
    public function getItemPrice(string $hashName, string $currency, int $lastDays = 7): ItemPriceProto
    {
        try {
            $json = $this->getJson(self::URL_GET_PRICE, [
                'currency' => $currency,
                'time' => $lastDays,
                'id' => $hashName
            ]);

            $status = $json->getDecodedJson()['success'] ?? null;

            if (null === $status || false === filter_var($status, FILTER_VALIDATE_BOOLEAN)) {
                $reason = $json->getDecodedJson()['reason'] ?? null;
                if ($reason && $reason === 'exceeded maximum number of requests, try again in next hour') {
                    throw new BPLimitExceed($reason);
                }

                throw new BPRequestFailed("Response status is false");
            }
            return new ItemPriceProto($json);
        } catch (BadResponseException | MissingProtoFieldException $e) {
            throw new BPRequestFailed($e->getMessage(), $e->getCode(), $e);
        }
    }
}
