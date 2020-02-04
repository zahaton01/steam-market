<?php

namespace App\Application\Resources\API\TM\Util;

use App\Application\Util\TextUtil;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class CSItemUtil
{
    public const URL_ITEM = 'https://market.csgo.com/en/item/';

    /**
     * @param string $instance
     *
     * @return string
     */
    public static function instanceLink(string $instance)
    {
        return self::URL_ITEM . TextUtil::replaceLowers($instance) ."/";
    }
}
