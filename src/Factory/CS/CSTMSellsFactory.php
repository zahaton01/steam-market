<?php

namespace App\Factory\CS;

use App\Entity\CS\CSItem;
use App\Entity\CS\TM\CSTMPricing;
use App\Entity\CS\TM\CSTMSell;
use App\Factory\CS\Resolver\CSFactoryInterface;
use App\Proto\TM\Sells\CS\CSTMSellsProto;

class CSTMSellsFactory implements CSFactoryInterface
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return CSTMSellsFactory::class;
    }

    /**
     * @param CSTMSellsProto $proto
     * @param CSItem $item
     *
     * @return CSTMPricing
     *
     * @throws \Exception
     */
    public function createFromSellsProto(CSTMSellsProto $proto, CSItem $item): CSTMPricing
    {
        $sells = new CSTMPricing();
        $sells
            ->setItem($item)
            ->setCreationDate(new \DateTime())
            ->setMaxPrice($proto->getMaxPrice())
            ->setMinPrice($proto->getMinPrice())
            ->setCurrency($proto->getCurrency());

        foreach ($proto->getSells() as $sellProto) {
            $sell = new CSTMSell();
            $sell
                ->setCurrency($proto->getCurrency())
                ->setCreationDate(new \DateTime())
                ->setSellDate($sellProto->getSellDate())
                ->setPricing($sells)
                ->setPrice($sellProto->getPrice());

            $sells->addSell($sell);
        }

        return $sells;
    }
}
