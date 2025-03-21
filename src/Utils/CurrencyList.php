<?php

namespace App\Utils;

use App\Model\CurrencyConfig;
use App\Providers\PriceProviderInterface;

class CurrencyList
{
    /** @var PriceProviderInterface[] $providers */
    private array $providers;
    private array $configurations = [];
    public function __construct(array $providers)
    {
        $this->providers = $providers;
        $markets = $this->getAllMarkets();
        $this->createCurrencyConfig($markets);
    }

    public function getAllMarkets(): array
    {
        $markets = [];
        foreach ($this->providers as $provider) {
            $markets = array_merge($markets, $provider->getAvailablePairs());
        }
        return $markets;
    }

    public function getCurrencyFromList(): array
    {
        $markets = $this->getAllMarkets();
        $currencies = [];
        foreach ($markets as $market) {
            [$currencyA,] = $this->transformMarketToCurrencies($market);
            $currencies[$currencyA] = $currencyA;
        }
        ksort($currencies);
        return $currencies;
    }

    public function createCurrencyConfig(array $markets): array
    {
        $this->configurations = [];
        foreach ($markets as $market) {
            [$currencyA, $currencyB] = $this->transformMarketToCurrencies($market);

            if (array_key_exists($currencyA, $this->configurations)) {
                $currencyConfig = $this->configurations[$currencyA];
                $currencyConfig->addCounterCurrency($currencyB);
            } else {
                $currencyConfig = new CurrencyConfig($currencyA, $currencyB);
                $this->configurations[$currencyA] = $currencyConfig;
            }
        }
        return $this->configurations;
    }

    public function getCurrencyToList(string $currency): array
    {
        /** @var CurrencyConfig $currencyConfig */
        $currencyConfig = $this->configurations[$currency];
        return $currencyConfig->getCounterCurrencies();
    }


    public function transformMarketToCurrencies(string $market): array
    {
        return explode('-', $market);
    }

    public function getProviders(): array
    {
        return $this->providers;
    }
}