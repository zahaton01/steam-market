<?php

namespace App\Domain\Factory\CS;

use App\Application\Resources\API\Steam\Model\SteamApp;
use App\Application\Resources\API\Steam\Util\SteamItemUtil;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Factory\AbstractFactory;
use App\Domain\Factory\CS\Resolver\CSFactoryInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class CSItemFactory extends AbstractFactory implements CSFactoryInterface
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
            ->setSteamLink(SteamItemUtil::itemLink($hashName, SteamApp::CS));

        return $item;
    }

}
