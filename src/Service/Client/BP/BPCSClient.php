<?php

namespace App\Service\Client\BP;

use App\Exception\BadResponseException;
use App\Exception\BP\BPLimitExceeded;
use App\Exception\BP\BPRequestFailed;
use App\Proto\BP\ItemList\ItemListProto;
use App\Proto\BP\ItemPrice\ItemPriceProto;
use App\Service\Client\AbstractClient;

class BPCSClient extends AbstractClient
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
        } catch (BadResponseException $e) {
            throw new BPRequestFailed($e->getMessage());
        }
    }

    /**
     * @param string $hashName
     * @param string $currency
     * @param int $lastDays
     *
     * @return ItemPriceProto
     *
     * @throws BPRequestFailed
     * @throws BPLimitExceeded
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
                    throw new BPLimitExceeded($reason);
                }

                throw new BPRequestFailed("Response status is false");
            }
            return new ItemPriceProto($json);
        } catch (BadResponseException $e) {
            throw new BPRequestFailed($e->getMessage());
        }
    }
}
