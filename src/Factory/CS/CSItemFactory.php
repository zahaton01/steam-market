<?php

namespace App\Factory\CS;

use App\Entity\CS\CSItem;
use App\Factory\CS\Resolver\CSFactoryInterface;
use App\Model\Steam\SteamApp;
use App\Util\Steam\SteamMarketplaceUtil;

class CSItemFactory implements CSFactoryInterface
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return CSItemFactory::class;
    }

    /**
     * @param string $hashName
     *
     * @return CSItem
     */
    public function create(string $hashName)
    {
        $item = new CSItem();
        $item
            ->setHashName($hashName)
            ->setIsAllowedForBuying(true)
            ->setIsAllowedForSelling(true)
            ->setSteamLink(SteamMarketplaceUtil::itemLink($hashName, SteamApp::CS));

        return $item;
    }
}
