<?php

namespace App\Service\ResourceAPIs\BP;

use App\Exception\BP\BPLimitExceeded;
use App\Exception\BP\BPRequestFailed;
use App\Proto\BP\ItemList\ItemListProto;
use App\Proto\BP\ItemPrice\ItemPriceProto;
use App\Service\Client\BP\BPCSClient;
use App\Service\ResourceAPIs\APIResourceInterface;

class BPResource implements APIResourceInterface
{
    /** @var BPCSClient */
    private $client;

    /**
     * BPResource constructor.
     * @param BPCSClient $client
     */
    public function __construct(BPCSClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return BPResource::class;
    }

    /**
     * @param string $currency
     *
     * @return ItemListProto
     *
     * @throws BPRequestFailed
     */
    public function retrieveItems(string $currency): ItemListProto
    {
        return $this->client->getItemList($currency);
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
    public function retrievePrice(string $hashName, string $currency, int $lastDays = 7): ItemPriceProto
    {
        return $this->client->getItemPrice($hashName, $currency, $lastDays);
    }
}
