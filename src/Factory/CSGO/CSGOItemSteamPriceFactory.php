<?php

namespace App\Factory\CSGO;

use App\Entity\CSGO\CSGOItem;
use App\Entity\CSGO\CSGOItemSteamPrice;

class CSGOItemSteamPriceFactory
{
    /**
     * @param float $price
     * @param float $average
     * @param string $currency
     * @param CSGOItem $item
     *
     * @return CSGOItemSteamPrice
     *
     * @throws \Exception
     */
    public function create(float $price, float $average, string $currency, CSGOItem $item): CSGOItemSteamPrice
    {
        $priceHistory = new CSGOItemSteamPrice();
        $priceHistory
            ->setCreationDate(new \DateTime())
            ->setPrice($price)
            ->setAverage($average)
            ->setCurrency($currency)
            ->setItem($item);

        return $priceHistory;
    }
}