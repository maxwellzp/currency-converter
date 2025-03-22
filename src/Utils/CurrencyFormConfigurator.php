<?php

namespace App\Utils;

use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;
use GuzzleHttp\Client as GuzzleClient;

class CurrencyFormConfigurator
{
    private CurrencyList $currencyList;

    public function __construct()
    {
        $guzzle = new GuzzleClient();
        $this->currencyList = new CurrencyList([
            new NBUProvider($guzzle),
            new BinanceProvider($guzzle),
            new PrivatBankProvider($guzzle),
            new MonobankProvider($guzzle),
        ]);

    }

    public function getCurrencyFromList(): array
    {
        return $this->currencyList->getCurrencyFromList();
    }

    public function getCurrencyToList(string $currency): array
    {
        return $this->currencyList->getCurrencyToList($currency);
    }

    public function getConfigurations(): array
    {
        return $this->currencyList->getConfigurations();
    }
}