<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

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
}