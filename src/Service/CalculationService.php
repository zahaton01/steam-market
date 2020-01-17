<?php

namespace App\Service;

use App\Model\Steam\CSGO\SteamCSGOItem;

class CalculationService
{
    /** @var float */
    private $CSGOPercentage;

    /**
     * CalculationService constructor.
     */
    public function __construct()
    {
        $this->CSGOPercentage = (float) $_ENV['CS_GO_STEAM_PERCENTAGE'];
    }

    /**
     * @param SteamCSGOItem $item
     *
     * @return float|int
     */
    public function getCSGOItemRealPrice(SteamCSGOItem $item)
    {
        return $item->getLowestPrice() * $this->CSGOPercentage * (1 - (float) $_ENV['TM_BUY_COMMISION']);
    }

    /**
     * @param SteamCSGOItem $item
     *
     * @return float|int
     */
    public function getCSGOItemMinSellPrice(SteamCSGOItem $item)
    {
        return $this->getCSGOItemRealPrice($item) * ( 1 +
            (float) $_ENV['TM_WITHDRAW_COMMISION'] +
            (float) $_ENV['TM_SELL_COMMISION'] +
            (float) $_ENV['EXPECTED_PROFIT']);
    }
}
