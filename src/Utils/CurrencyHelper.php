<?php

declare(strict_types=1);

namespace App\Utils;

use Alcohol\ISO4217;

class CurrencyHelper
{
    public function __construct(private ISO4217 $iso4217)
    {
    }

    public function getCurrencyAlpha3ByCode(int $currency): string
    {
        $normalizedCodeA = str_pad(strval($currency), 3, '0', STR_PAD_LEFT);
        $currencyData = $this->iso4217->getByCode($normalizedCodeA);

        return $currencyData['alpha3'];
    }

    public function getCurrencyNameByAlpha3(string $currency): string
    {
        $currencyData = $this->iso4217->getByAlpha3($currency);
        return $currencyData['name'];
    }
}
