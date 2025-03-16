<?php

declare(strict_types=1);

namespace App\Providers;

interface PriceProviderInterface
{
    public function getPrice(): string;
}