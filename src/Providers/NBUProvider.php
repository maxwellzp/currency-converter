<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

// https://bank.gov.ua/ua/open-data/api-dev
class NBUProvider implements PriceProviderInterface
{
    const API_URL = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';
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
        return "nbu";
    }

    public function getAvailablePairs(): array
    {
        return [];
    }
}