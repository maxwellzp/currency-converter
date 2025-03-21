<?php

declare(strict_types=1);

namespace App\Model;

class CurrencyConfig
{
    private string $baseCurrency;
    private array $counterCurrencies;

    public function __construct(string $baseCurrency, string $counterCurrency)
    {
        $this->baseCurrency = $baseCurrency;
        $this->counterCurrencies[] = $counterCurrency;
    }

    public function addCounterCurrency(string $counterCurrency): void
    {
        if (!in_array($counterCurrency, $this->counterCurrencies)) {
            $this->counterCurrencies[] = $counterCurrency;
        }
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    public function getCounterCurrencies(): array
    {
        return $this->counterCurrencies;
    }
}
