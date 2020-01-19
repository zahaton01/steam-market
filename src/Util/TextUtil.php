<?php

namespace App\Util;

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
}