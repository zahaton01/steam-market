<?php


namespace App\Factory\CS;


use App\Entity\CS\CSItem;
use App\Entity\CS\Steam\CSSteamPrice;
use App\Factory\CS\Resolver\CSFactoryInterface;
use App\Proto\Steam\CS\CSSteamPriceOverviewProto;

class CSSteamPriceFactory implements CSFactoryInterface
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return CSSteamPriceFactory::class;
    }

    /**
     * @param CSSteamPriceOverviewProto $proto
     * @param CSItem $item
     * @param string $currency
     *
     * @return CSSteamPrice
     *
     * @throws \Exception
     */
    public function createFromPriceOverviewProto(CSSteamPriceOverviewProto $proto, CSItem $item, string $currency): CSSteamPrice
    {
        $price = new CSSteamPrice();
        $price
            ->setPrice($proto->getLowestPrice())
            ->setMedianPrice($proto->getMedianPrice())
            ->setCurrency($currency)
            ->setCreationDate(new \DateTime())
            ->setItem($item);

        return $price;
    }
}
