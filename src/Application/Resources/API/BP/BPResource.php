<?php

namespace App\Application\Resources\API\BP;

use App\Application\Resources\API\BP\Client\BPJsonClient;
use App\Application\Resources\ApiResourceInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class BPResource implements ApiResourceInterface
{
    /** @var BPJsonClient */
    private $jsonClient;

    /**
     * BPResource constructor.
     * @param BPJsonClient $client
     */
    public function __construct(BPJsonClient $client)
    {
        $this->jsonClient = $client;
    }

    /**
     * @param string $currency
     *
     * @return Proto\ItemList\ItemListProto
     *
     * @throws Exception\BPRequestFailed
     */
    public function getItemList(string $currency)
    {
        return $this->jsonClient->getItemList($currency);
    }

    /**
     * @param string $hashName
     * @param string $currency
     * @param int $lastDays
     *
     * @return Proto\ItemPrice\ItemPriceProto
     *
     * @throws Exception\BPLimitExceed
     * @throws Exception\BPRequestFailed
     */
    public function getItemPrice(string $hashName, string $currency, int $lastDays = 7)
    {
        return $this->jsonClient->getItemPrice($hashName, $currency, $lastDays);
    }
}
