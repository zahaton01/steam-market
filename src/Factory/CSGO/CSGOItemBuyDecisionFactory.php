<?php

namespace App\Factory\CSGO;

use App\Entity\CSGO\CSGOItemBuyDecision;
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
            ->setCurrency($item->getCurrency())
            ->setMarketPrice($instance->getPrice())
            ->setSteamPrice($item->getLowestPrice());

        return $decision;
    }
}
