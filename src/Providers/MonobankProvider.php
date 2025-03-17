<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

// https://monobank.ua/api-docs/monobank/publichni-dani/get--bank--currency
class MonobankProvider implements PriceProviderInterface
{
    const API_URL = 'https://api.monobank.ua/bank/currency';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getPrices(): array
    {

        return [];
    }

    public function getName(): string
    {
        return "monobank";
    }

    public function getAvailablePairs(): array
    {
        return [];
    }
}