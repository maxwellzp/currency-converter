<?php

declare(strict_types=1);

namespace App\Utils;

use Alcohol\ISO4217;

class CurrencyHelper
{
    public static function getCurrencyAlpha3ByCode(int $currency): string
    {
        $iso4217 = new ISO4217();
        $normalizedCodeA = str_pad(strval($currency), 3, '0', STR_PAD_LEFT);
        $currencyData = $iso4217->getByCode($normalizedCodeA);

        return $currencyData['alpha3'];
    }

    public static function getCurrencyNameByAlpha3(string $currency): string
    {
        $iso4217 = new ISO4217();
        $currencyData = $iso4217->getByAlpha3($currency);
        return $currencyData['name'];
    }
}
