<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

// https://monobank.ua/api-docs/monobank/publichni-dani/get--bank--currency
class MonobankProvider implements PriceProviderInterface
{
    private const API_URL = 'https://api.monobank.ua/bank/currency';

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
     * @param string $json
     * @return array
     */
    public function parsingResponse(string $json): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getPrices(): array
    {

        return [];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "monobank";
    }

    /**
     * @return array
     */
    public function getAvailablePairs(): array
    {
        return [];
    }
}
