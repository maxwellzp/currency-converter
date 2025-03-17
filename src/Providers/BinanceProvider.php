<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

class BinanceProvider implements PriceProviderInterface
{
    const API_URL = 'https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function makeApiRequest(): string
    {
        $response = $this->client->request('GET', self::API_URL);
        return $response->getBody()->getContents();
    }

    public function getPrices(): array
    {
        $json = $this->makeApiRequest();
        return $this->parsingResponse($json);
    }

    public function parsingResponse(string $json): array
    {
        $result = [];
        $rate = json_decode($json, true);

        $result[] = ["BTC-USD", $rate['price']];

        return $result;
    }

    public function getName(): string
    {
        return "binance";
    }

    public function getAvailablePairs(): array
    {
        return ['BTC-USD'];
    }
}