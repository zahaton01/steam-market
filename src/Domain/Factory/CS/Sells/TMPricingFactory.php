<?php

namespace App\Domain\Factory\CS\Sells;

use App\Application\Model\Currency;
use App\Application\Resources\API\TM\Proto\Sells\Model\TMPricing;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Entity\CS\TM\CSTMPricing;
use App\Domain\Entity\CS\TM\CSTMSell;
use App\Domain\Factory\AbstractFactory;
use App\Domain\Factory\CS\CSFactoryInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class TMPricingFactory extends AbstractFactory implements CSFactoryInterface
{
    /**
     * @param TMPricing $tmPricing
     * @param CSItem $item
     *
     * @return CSTMPricing
     */
    public function createFromTM(TMPricing $tmPricing, CSItem $item): CSTMPricing
    {
        $pricing = new CSTMPricing();
        $pricing
            ->setMaxPrice($tmPricing->getMaxPrice())
            ->setMinPrice($tmPricing->getMinPrice())
            ->setCurrency(Currency::RUB)
            ->setCreationDate($this->getCurrentDate())
            ->setItem($item)
            ->setAverage($tmPricing->getAverage());

        foreach ($tmPricing->getSells() as $tmSell) {
            $sell = new CSTMSell();
            $sell
                ->setCreationDate($this->getCurrentDate())
                ->setCurrency(Currency::RUB)
                ->setSellDate($tmSell->getSellDate())
                ->setPrice($tmSell->getPrice())
                ->setPricing($pricing);

            $pricing->addSell($sell);
        }

        return $pricing;
    }
}