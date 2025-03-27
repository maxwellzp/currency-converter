<?php

declare(strict_types=1);

namespace App\Model;

class CurrencyConfig
{
    private string $baseCurrency;

    /**
     * @var array<string>
     */
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

    /**
     * @return string
     */
    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    /**
     * @return array|string[]
     */
    public function getCounterCurrencies(): array
    {
        return $this->counterCurrencies;
    }
}
