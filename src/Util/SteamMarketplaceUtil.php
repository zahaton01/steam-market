<?php

namespace App\Util;

use App\Service\Steam\SteamMarketplace;

class SteamMarketplaceUtil
{
    /**
     * @param int $hashName
     * @param int $app
     *
     * @return string
     */
    public static function itemLink(int $hashName, int $app)
    {
        return SteamMarketplace::LISTING_URL . "$app/$hashName";
    }
}