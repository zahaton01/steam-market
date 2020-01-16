<?php

namespace App\Service;

class TextService
{
    /**
     * @param string $string
     * @return float
     */
    public static function getFloatFromSteamResponse(string $string)
    {
        $string = str_replace(',', '.', $string); // json return nums like 446,0 but in php we need .

        return (float) filter_var($string, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}