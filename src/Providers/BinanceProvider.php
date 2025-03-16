<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

class BinanceProvider implements PriceProviderInterface
{
    const API_URL = 'https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT';

    public function getPrice(): string
    {
        $client = new Client();
        $response = $client->request('GET', self::API_URL);
        $body = $response->getBody();
        echo $body . PHP_EOL;

        return "0";
    }
}