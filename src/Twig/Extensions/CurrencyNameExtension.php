<?php

namespace App\Twig\Extensions;

use App\Utils\CurrencyHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CurrencyNameExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('currency_name', [$this, 'currencyName']),
        ];
    }

    public function currencyName(string $alpha3): string
    {
        if ($alpha3 == 'BTC') {
            return sprintf("%s (%s)", $alpha3, 'Bitcoin');
        } else {
            return sprintf("%s (%s)", $alpha3, CurrencyHelper::getCurrencyNameByAlpha3($alpha3));
        }
    }
}
