<?php

namespace App\Util\Steam;

use App\Service\Marketplace\Steam\SteamMarketplace;

class SteamMarketplaceUtil
{
    /**
     * @param string $hashName
     * @param int $app
     *
     * @return string
     */
    public static function itemLink(string $hashName, int $app)
    {
        return SteamMarketplace::LISTING_URL . "$app/$hashName";
    }
}
