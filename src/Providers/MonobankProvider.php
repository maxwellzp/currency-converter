<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

// https://monobank.ua/api-docs/monobank/publichni-dani/get--bank--currency
class MonobankProvider implements PriceProviderInterface
{
    const API_URL = 'https://api.monobank.ua/bank/currency';

    public function getPrice(): string
    {
        $client = new Client();
        $response = $client->request('GET', self::API_URL);
        $body = $response->getBody();
        echo $body . PHP_EOL;

        return "0";
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