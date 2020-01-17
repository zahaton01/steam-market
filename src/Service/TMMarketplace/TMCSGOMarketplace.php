<?php

namespace App\Service\TMMarketplace;

use App\Exception\TMMarketplace\TMItemNotFound;
use App\Exception\TMMarketplace\TMRequestFailed;
use App\Model\Currency;
use App\Model\TMMarketplace\CSGO\TMCSGOItemCurrentInstance;
use App\Model\TMMarketplace\CSGO\TMCSGOItemCurrentPrice;
use App\Service\TextService;

class TMCSGOMarketplace
{
    /** @var TMCSGOMarketplaceClient */
    private $client;

    /**
     * TMCSGOMarketplace constructor.
     * @param TMCSGOMarketplaceClient $client
     */
    public function __construct(TMCSGOMarketplaceClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $currency
     *
     * @return TMCSGOItemCurrentPrice[]
     *
     * @throws TMRequestFailed
     */
    public function retrieveCurrentPrices(string $currency = Currency::RUB)
    {
        $json = $this->client->retrieveCurrentPrices($currency);

        $result = [];
        foreach ($json['items'] as $item) {
            $TMCSGOItemCurrentPrice = new TMCSGOItemCurrentPrice();
            $TMCSGOItemCurrentPrice
                ->setPrice($item['price'])
                ->setCurrency($currency)
                ->setHashName($item['market_hash_name']);

            $result[] = $TMCSGOItemCurrentPrice;
        }

        return $result;
    }

    /**
     * @param string $currency
     *
     * @return TMCSGOItemCurrentInstance[]
     *
     * @throws TMRequestFailed
     */
    public function retrieveCurrentInstances(string $currency = Currency::RUB)
    {
        $json = $this->client->retrieveCurrentInstances($currency);

        $result = [];
        foreach ($json['items'] as $name => $item) {
            $TMCSGOItemCurrentInstance = new TMCSGOItemCurrentInstance();
            $TMCSGOItemCurrentInstance
                ->setInstance($name)
                ->setPrice($item['price'])
                ->setCurrency($currency)
                ->setBuyOrder($item['buy_order'])
                ->setMedianPrice($item['avg_price'])
                ->setLink("https://market.csgo.com/en/item/$name/")
                ->setHashName($item['market_hash_name']);

            $result[] = $TMCSGOItemCurrentInstance;
        }

        return $result;
    }

    /**
     * @param string $hashName
     * @param string $currency
     *
     * @return TMCSGOItemCurrentInstance
     *
     * @throws TMRequestFailed
     */
    public function retrieveInstance(string $hashName, string $currency = Currency::RUB)
    {
        $json = $this->client->retrieveInstance($hashName);
        $item = $json['data'][0];
        $instance = $item['class'] . '_' . $item['instance'];

        $TMCSGOItemCurrentInstance = new TMCSGOItemCurrentInstance();
        $TMCSGOItemCurrentInstance
            ->setInstance($instance)
            ->setPrice($item['price'] / 100)
            ->setLink("https://market.csgo.com/en/item/" . TextService::replaceLowers($instance) . "/")
            ->setHashName($item['market_hash_name']);

        return $TMCSGOItemCurrentInstance;
    }

    /**
     * @param string $hashName
     *
     * @return array
     *
     * @throws TMItemNotFound
     * @throws TMRequestFailed
     */
    public function retrieveDetails(string $hashName)
    {
        $details = $this->client->retrieveItemDetails($hashName)['data'][$hashName] ?? null;

        if (null === $details) {
            throw new TMItemNotFound();
        }

        return $details;
    }
}
