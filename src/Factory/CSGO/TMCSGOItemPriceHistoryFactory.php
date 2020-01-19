<?php

namespace App\Factory\CSGO;

use App\Entity\CSGO\CSGOItem;
use App\Entity\CSGO\TMCSGOItemSellHistory;
use App\Model\TMMarketplace\CSGO\TMCSGOItemPriceHistory;

class TMCSGOItemPriceHistoryFactory
{
    public function createFromDetails(TMCSGOItemPriceHistory $history, CSGOItem $item): \App\Entity\CSGO\TMCSGOItemPriceHistory
    {
        $entity = new \App\Entity\CSGO\TMCSGOItemPriceHistory();
        $entity
            ->setItem($item)
            ->setMinPrice($history->getMinPrice())
            ->setMaxPrice($history->getMaxPrice())
            ->setAverage($history->getAverage());

        foreach ($history->getSells() as $sell) {
            $sellEntity = new TMCSGOItemSellHistory();
            $sellEntity
                ->setPrice($sell->getPrice())
                ->setSellDate($sell->getSellDate())
                ->setCreationDate(new \DateTime())
                ->setPriceHistory($entity);

            $entity->addSell($sellEntity);
        }

        return $entity;
    }
}