<?php

namespace App\Domain\Factory\CS\Item;

use App\Application\Resources\API\Steam\Model\SteamApp;
use App\Application\Resources\API\Steam\Util\SteamItemUtil;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Factory\AbstractFactory;
use App\Domain\Factory\CS\CSFactoryInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class CSItemFactory extends AbstractFactory implements CSFactoryInterface
{
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
            ->setSteamLink(SteamItemUtil::itemLink($hashName, SteamApp::CS));

        return $item;
    }
}
