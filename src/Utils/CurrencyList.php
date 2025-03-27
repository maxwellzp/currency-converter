<?php

declare(strict_types=1);

namespace App\Utils;

use App\Model\CurrencyConfig;
use App\Providers\PriceProviderInterface;

class CurrencyList
{
    /** @var PriceProviderInterface[] $providers */
    private array $providers;
    /**
     * @var array<string,CurrencyConfig>
     */
    private array $configurations = [];

    /**
     * @param PriceProviderInterface[] $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
        $markets = $this->getAllMarkets();
        $this->createCurrencyConfigs($markets);
    }

    /**
     * @return string[]
     */
    public function getAllMarkets(): array
    {
        $markets = [];
        foreach ($this->providers as $provider) {
            $markets = array_merge($markets, $provider->getAvailablePairs());
        }
        sort($markets);
        return $markets;
    }

    /**
     * @return array<string,string>
     */
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

    /**
     * @param string $currency
     * @return string[]
     * @throws \Exception
     */
    public function getCurrencyToList(string $currency): array
    {
        /** @var CurrencyConfig $currencyConfig */
        $currencyConfig = $this->configurations[$currency];
        if ($currencyConfig == null) {
            throw new \Exception('Currency not found in configurations: ' . $currency);
        }
        return $currencyConfig->getCounterCurrencies();
    }

    /**
     * @param string[] $markets
     * @return void
     */
    public function createCurrencyConfigs(array $markets): void
    {
        $this->direct($markets);
        $this->invers($markets);
        $this->cross($markets);
    }

    /**
     * @param string $market
     * @return string[]
     */
    public function transformMarketToCurrencies(string $market): array
    {
        return explode('-', $market);
    }

    /**
     * @return array|PriceProviderInterface[]
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    /**
     * @param string[] $markets
     * @return void
     */
    public function direct(array $markets): void
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

    /**
     * @param string[] $markets
     * @return void
     */
    public function invers(array $markets): void
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

    /**
     * @param string[] $markets
     * @return void
     */
    public function cross(array $markets): void
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

    /**
     * @param string $baseCurrency
     * @param string $counterCurrency
     * @return CurrencyConfig
     */
    public function createCurrencyConfig(string $baseCurrency, string $counterCurrency): CurrencyConfig
    {
        return new CurrencyConfig($baseCurrency, $counterCurrency);
    }

    /**
     * @param string $currency
     * @return bool
     */
    public function isCurrencyConfigExists(string $currency): bool
    {
        return array_key_exists($currency, $this->configurations);
    }

    /**
     * @param string $currency
     * @return CurrencyConfig
     */
    public function getCurrencyConfigByCurrencyId(string $currency): CurrencyConfig
    {
        return $this->configurations[$currency];
    }

    /**
     * @param string $currency
     * @param CurrencyConfig $currencyConfig
     * @return void
     */
    public function setCurrencyConfigByCurrencyId(string $currency, CurrencyConfig $currencyConfig): void
    {
        $this->configurations[$currency] = $currencyConfig;
    }

    /**
     * @return array<string,CurrencyConfig>
     */
    public function getConfigurations(): array
    {
        return $this->configurations;
    }
}
