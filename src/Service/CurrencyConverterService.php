<?php

declare(strict_types=1);

namespace App\Service;

class CurrencyConverterService
{
    public function __construct(
        private RedisService $redisService,
    ) {
    }

    /**
     * @param string $amount
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return float
     * @throws \Exception
     */
    public function convert(string $amount, string $currencyFrom, string $currencyTo): float
    {
        if ($currencyTo === $currencyFrom) {
            return (float)$amount;
        }

        $methods = ['directExchangeRate', 'indirectExchangeRate', 'crossExchangeRate'];

        foreach ($methods as $method) {
            $exchangeRate = $this->$method($currencyFrom, $currencyTo);
            if ($exchangeRate !== null) {
                return $amount * $exchangeRate;
            }
        }

        throw new \Exception(sprintf('There is no exchange rate for %s-%s', $currencyFrom, $currencyTo));
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function fetchFromRedis(string $key): string|null
    {
        return $this->redisService->get($key);
    }

    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return string|null
     */
    public function directExchangeRate(string $currencyFrom, string $currencyTo): string|null
    {
        // We want to receive BTC-USD price
        // Approximately = 3456493.90
        // $currencyFrom = BTC
        // $currencyTo = USD

        $key = sprintf('%s-%s', $currencyFrom, $currencyTo);
        return $this->fetchFromRedis($key);
    }

    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return float|null
     */
    public function crossExchangeRate(string $currencyFrom, string $currencyTo): null|float
    {
        // We want to receive BTC-UAH price
        // Approximately = 3456493.90
        // $currencyFrom = BTC
        // $currencyTo = UAH

        // But we have only the following prices so we can calculate BTC-UAH through base USD currency
        // BTC-USD price = 83331.03
        // USD-UAH price = 41.43

        // In our case the base currency is USD
        $firstPairKey = sprintf('%s-%s', $currencyFrom, 'USD');
        $firstPairPrice = $this->fetchFromRedis($firstPairKey);
        if ($firstPairPrice === null) {
            return null;
        }
        $secondPairKey = sprintf('%s-%s', 'USD', $currencyTo);
        $secondPairPrice = $this->fetchFromRedis($secondPairKey);
        if ($secondPairPrice === null) {
            return null;
        }

        return floatval($firstPairPrice) * floatval($secondPairPrice); //83331.03 × 41.43 = 3452404.5729
    }

    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return string|null
     */
    public function indirectExchangeRate(string $currencyFrom, string $currencyTo): null|string
    {
        // We want to receive USD-BTC price
        // BTC-USD = 87,541.83
        // USD-BTC = 1 / 87,541.83 = 0.00001142
        $key = sprintf('%s-%s', $currencyFrom, $currencyTo);
        $directRate = $this->fetchFromRedis($key);
        if ($directRate === null) {
            return null;
        }
        return strval((1 / floatval($directRate)));
    }
}
