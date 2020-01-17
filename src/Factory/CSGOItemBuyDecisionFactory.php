<?php

namespace App\Factory;

use App\Entity\CSGOItemBuyDecision;
use App\Model\Steam\CSGO\SteamCSGOItem;
use App\Model\TMMarketplace\CSGO\TMCSGOItemCurrentInstance;

class CSGOItemBuyDecisionFactory
{
    /**
     * @param SteamCSGOItem $item
     * @param TMCSGOItemCurrentInstance $instance
     *
     * @return CSGOItemBuyDecision
     */
    public function createFromItemAndInstance(SteamCSGOItem $item, TMCSGOItemCurrentInstance $instance)
    {
        $decision = new CSGOItemBuyDecision();
        $decision
            ->setInstance($instance->getInstance())
            ->setHashName($instance->getHashName())
            ->setCurrency($item->getCurrency())
            ->setMarketPrice($instance->getPrice())
            ->setSteamMarketplaceUrl($item->getMarketplaceUrl())
            ->setTmMarketplaceUrl($instance->getLink())
            ->setSteamPrice($item->getLowestPrice());

        return $decision;
    }
}
