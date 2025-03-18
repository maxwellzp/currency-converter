<?php

declare(strict_types=1);

namespace App\Providers;

interface PriceProviderInterface
{
    public function getPrices(): array;
    public function parsingResponse(string $json): array;
    public function getName(): string;
    public function getAvailablePairs(): array;
}
