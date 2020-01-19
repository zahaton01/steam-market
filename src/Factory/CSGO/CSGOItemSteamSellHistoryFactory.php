<?php

namespace App\Factory\CSGO;

use App\Entity\CSGO\CSGOItemSteamSellHistory;

class CSGOItemSteamSellHistoryFactory
{
    public function createFromJson(array $data): CSGOItemSteamSellHistory
    {
        $sell = new CSGOItemSteamSellHistory();
        $sell
            ->setCreationDate(new \DateTime())
            ->setSellDate($data[0])
            ->setPrice($data[1])
            ->setAmount($data[2]);

        return $sell;
    }
}