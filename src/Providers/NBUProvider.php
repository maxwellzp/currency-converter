<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

// https://bank.gov.ua/ua/open-data/api-dev
class NBUProvider implements PriceProviderInterface
{
    const API_URL = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';

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
        return "nbu";
    }

    public function getAvailablePairs(): array
    {
        return [];
    }
}