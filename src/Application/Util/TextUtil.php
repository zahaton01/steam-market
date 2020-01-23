<?php

namespace App\Application\Util;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class TextUtil
{
    /**
     * @param string $string
     * @param string $replacer
     *
     * @return string
     */
    public static function replaceCommas(string $string, string $replacer = '.')
    {
        return str_replace(',', $replacer, $string);
    }

    /**
     * @param string $string
     * @param string $replacer
     *
     * @return string
     */
    public function replaceLowers(string $string, string $replacer = '-')
    {
        return str_replace('_', $replacer, $string);
    }
}
