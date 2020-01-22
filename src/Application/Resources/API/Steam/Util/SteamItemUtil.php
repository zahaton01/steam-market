<?php

namespace App\Application\Resources\API\Steam\Util;

class SteamItemUtil
{
    public const URL_LISTING = 'https://steamcommunity.com/market/listings/';

    /**
     * @param string $hashName
     * @param int $app
     *
     * @return string
     */
    public static function itemLink(string $hashName, int $app)
    {
        return self::URL_LISTING . "$app/$hashName";
    }
}
