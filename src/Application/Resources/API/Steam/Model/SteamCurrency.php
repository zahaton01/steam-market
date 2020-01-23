<?php

namespace App\Application\Resources\API\Steam\Model;

use App\Application\Model\Currency;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class SteamCurrency
{
    public const USD = 1;
    public const RUB = 5;
    public const UAH = 18;

    public const SUFFIX_UAH = '₴';

    /**
     * @param string $currency
     * @return string
     */
    public static function fromApp(string $currency)
    {
        switch ($currency) {
            case Currency::RUB:
                return static::RUB;
                break;
            default:
                return static::USD;
                break;
        }
    }
}
