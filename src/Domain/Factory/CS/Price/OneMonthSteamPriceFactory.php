<?php

namespace App\Domain\Factory\CS\Price;

use App\Domain\Entity\CS\Steam\AbstractSteamPrice;
use App\Domain\Entity\CS\Steam\Price\OneMonthSteamPrice;
use App\Domain\Factory\CS\CSFactoryInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class OneMonthSteamPriceFactory extends AbstractSteamPriceFactory implements CSFactoryInterface
{
    /**
     * @return AbstractSteamPrice
     */
    public function createEmpty(): AbstractSteamPrice
    {
        return new OneMonthSteamPrice();
    }
}