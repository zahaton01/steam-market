<?php

namespace App\Domain\Factory\CS\Price;

use App\Application\Model\Currency;
use App\Application\Resources\API\BP\Proto\ItemList\Model\ItemPrice;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Entity\CS\Steam\AbstractSteamPrice;
use App\Domain\Factory\AbstractFactory;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractSteamPriceFactory extends AbstractFactory
{
    /**
     * @param ItemPrice $itemPrice
     * @param CSItem|null $CSItem
     * @param string $currency
     *
     * @return AbstractSteamPrice
     */
    public function createFromBP(ItemPrice $itemPrice, CSItem $CSItem = null, string $currency = Currency::RUB): AbstractSteamPrice
    {
        $price = $this->createEmpty();

        $price
            ->setCreationDate($this->getCurrentDate())
            ->setAverage($itemPrice->getAverage())
            ->setMedian($itemPrice->getMedian())
            ->setLowestPrice($itemPrice->getLowestPrice())
            ->setHighestPrice($itemPrice->getHighestPrice())
            ->setSold($itemPrice->getSold())
            ->setItem($CSItem)
            ->setCurrency($currency);

        return $price;
    }

    /**
     * @return AbstractSteamPrice
     */
    abstract function createEmpty(): AbstractSteamPrice;
}