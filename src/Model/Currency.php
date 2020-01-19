<?php

namespace App\Model;

use App\Model\Steam\SteamCurrency;

class Currency
{
    public const RUB = 'RUB';
    public const USD = 'USD';
    public const UAH = 'UAH';

    /**
     * @param int $steamCurrency
     * @return string
     */
    public static function fromSteam(int $steamCurrency)
    {
        switch ($steamCurrency) {
            case SteamCurrency::RUB:
                return static::RUB;
                break;
            default:
                return static::USD;
                break;
        }
    }
}
