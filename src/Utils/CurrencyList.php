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
        $this->createCurrencyConfigs($markets);
    }

    public function getAllMarkets(): array
    {
        $markets = [];
        foreach ($this->providers as $provider) {
            $markets = array_merge($markets, $provider->getAvailablePairs());
        }
        sort($markets);
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

    public function getCurrencyToList(string $currency): array
    {
        /** @var CurrencyConfig $currencyConfig */
        $currencyConfig = $this->configurations[$currency];
        return $currencyConfig->getCounterCurrencies();
    }

    public function createCurrencyConfigs(array $markets): void
    {
        $this->direct($markets);
        $this->invers($markets);
        $this->cross($markets);
    }

    public function transformMarketToCurrencies(string $market): array
    {
        return explode('-', $market);
    }

    public function getProviders(): array
    {
        return $this->providers;
    }

    public function direct(array $markets)
    {
        foreach ($markets as $market) {
            [$currencyA, $currencyB] = $this->transformMarketToCurrencies($market);

            if ($this->isCurrencyConfigExists($currencyA)) {
                $currencyConfig = $this->getCurrencyConfigByCurrencyId($currencyA);
                $currencyConfig->addCounterCurrency($currencyB);
            } else {
                $currencyConfig = $this->createCurrencyConfig($currencyA, $currencyB);
                $this->setCurrencyConfigByCurrencyId($currencyA, $currencyConfig);
            }
        }
    }

    public function invers(array $markets)
    {
        foreach ($markets as $market) {
            [$currencyA, $currencyB] = $this->transformMarketToCurrencies($market);

            if ($this->isCurrencyConfigExists($currencyB)) {
                $currencyConfig = $this->getCurrencyConfigByCurrencyId($currencyB);
                $currencyConfig->addCounterCurrency($currencyA);
            } else {
                $currencyConfig = $this->createCurrencyConfig($currencyB, $currencyA);
                $this->setCurrencyConfigByCurrencyId($currencyB, $currencyConfig);
            }
        }
    }

    public function cross(array $markets)
    {
        $uniqueMarkets = array_unique($markets);
        $resultPairs = [];
        // Calculate each to each
        foreach ($uniqueMarkets as $marketA) {

            [$currencyA,] = $this->transformMarketToCurrencies($marketA);

            $firstPairKey = sprintf('%s-%s', $currencyA, 'USD');
            if (!in_array($firstPairKey, $uniqueMarkets)) {
                continue;
            }

            foreach ($uniqueMarkets as $marketB) {
                [, $currencyB] = $this->transformMarketToCurrencies($marketB);
                $secondPairKey = sprintf('%s-%s', 'USD', $currencyB);
                if (!in_array($secondPairKey, $uniqueMarkets)) {
                    continue;
                }
                $str = sprintf("%s-%s", $currencyA, $currencyB);
                $resultPairs[$str] = $str;
            }
        }

        foreach ($resultPairs as $strPairs) {
            [$currencyA, $currencyB] = $this->transformMarketToCurrencies($strPairs);
            if ($this->isCurrencyConfigExists($currencyA)) {
                $currencyConfig = $this->getCurrencyConfigByCurrencyId($currencyA);
                $currencyConfig->addCounterCurrency($currencyB);
            } else {
                $currencyConfig = $this->createCurrencyConfig($currencyA, $currencyB);
                $this->setCurrencyConfigByCurrencyId($currencyA, $currencyConfig);
            }
        }
    }

    public function createCurrencyConfig(string $baseCurrency, string $counterCurrency)
    {
        return new CurrencyConfig($baseCurrency, $counterCurrency);
    }

    public function isCurrencyConfigExists(string $currency): bool
    {
        return array_key_exists($currency, $this->configurations);
    }

    public function getCurrencyConfigByCurrencyId(string $currency): CurrencyConfig
    {
        return $this->configurations[$currency];
    }

    public function setCurrencyConfigByCurrencyId(string $currency, CurrencyConfig $currencyConfig): void
    {
        $this->configurations[$currency] = $currencyConfig;
    }

    public function getConfigurations(): array
    {
        return $this->configurations;
    }
}
