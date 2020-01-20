<?php

namespace App\Util;


use App\Service\Marketplace\TM\TMCSMarketplace;

class TMMarketplaceUtil
{
    /**
     * @param string $instance
     *
     * @return string
     */
    public static function instanceLink(string $instance)
    {
        return TMCSMarketplace::INSTANCE_LINK . "$instance/";
    }
}
