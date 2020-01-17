<?php

namespace App\Model;

use App\Model\Steam\SteamCurrency;

class Currency
{
    public const RUB = 'RUB';
    public const USD = 'USD';

    /**
     * @param int $currency
     * @return string
     */
    public static function getFromSteamCurrency(int $currency)
    {
        switch ($currency) {
            case SteamCurrency::RUB:
                return static::RUB;
                break;
            default:
                return static::USD;
                break;
        }
    }
}
