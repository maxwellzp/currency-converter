<?php

namespace App\Utils;

use Alcohol\ISO4217;

class CurrencyHelper
{
    public static function getCurrencyNameByCode(int $currency): string
    {
        $iso4217 = new ISO4217();

        $normalizedCodeA = str_pad(strval($currency), 3, '0', STR_PAD_LEFT);

        $currencyName = $iso4217->getByCode($normalizedCodeA);

        return $currencyName['alpha3'];
    }
}
