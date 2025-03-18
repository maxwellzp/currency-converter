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

    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeApiRequest(): string
    {
        $response = $this->client->request('GET', self::API_URL);
        return $response->getBody()->getContents();
    }

    /**
     * @return array
     */
    public function getPrices(): array
    {
        $json = $this->makeApiRequest();
        return $this->parsingResponse($json);
    }

    /**
     * @param string $json
     * @return array
     */
    public function parsingResponse(string $json): array
    {
        $result = [];
        $rate = json_decode($json, true);

        $result[] = ["BTC-USD", $rate['price']];

        return $result;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "binance";
    }

    /**
     * @return string[]
     */
    public function getAvailablePairs(): array
    {
        return ['BTC-USD'];
    }
}