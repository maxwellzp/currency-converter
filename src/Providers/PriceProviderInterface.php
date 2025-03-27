<?php

declare(strict_types=1);

namespace App\Providers;

interface PriceProviderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function getMarketRates(): array;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string[]
     */
    public function getAvailablePairs(): array;
}
