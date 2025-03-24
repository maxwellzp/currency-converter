<?php

namespace App\Twig\Extensions;

use Alcohol\ISO4217;
use App\Utils\CurrencyHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CurrencyNameExtension extends AbstractExtension
{
    public function __construct(private CurrencyHelper $currencyHelper)
    {
    }

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
            return sprintf("%s (%s)", $alpha3, $this->currencyHelper->getCurrencyNameByAlpha3($alpha3));
        }
    }
}
