<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

class PrivatBankProvider
{
    const API_URL = 'https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5';

    public function getPrice(): string
    {
        $client = new Client();
        $response = $client->request('GET', self::API_URL);
        $body = $response->getBody();
        echo $body . PHP_EOL;

        return "0";
    }
}