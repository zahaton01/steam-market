<?php

namespace App\Factory\CSGO;

use App\Entity\CSGO\CSGOItem;
use App\Model\TMMarketplace\CSGO\TMCSGOItemCurrentInstance;

class CSGOItemFactory
{
    /**
     * @param TMCSGOItemCurrentInstance $instance
     *
     * @return CSGOItem
     */
    public function createFromInstance(TMCSGOItemCurrentInstance $instance): CSGOItem
    {
        $item = new CSGOItem();
        $item
            ->setHashName($instance->getHashName())
            ->setInstance($instance->getInstance())
            ->setIsAllowedForSelling(true)
            ->setIsAllowedForBuying(true)
            ->setTmMarketplaceUrl($instance->getLink());

        return $item;
    }
}