<?php

namespace App\Providers;

interface PriceProviderInterface
{
    public function getPrice(): string;
}