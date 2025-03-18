<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

// https://api.privatbank.ua/#p24/exchange
class PrivatBankProvider implements PriceProviderInterface
{
    const API_URL = 'https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5';

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
        $rates = json_decode($json, true);

        foreach ($rates as $rate) {
            $pair = sprintf("%s-%s", $rate['ccy'], $rate['base_ccy']);
            $price = ($rate['buy'] + $rate['sale']) / 2;
            $result[] = [$pair, $price];
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "privatbank";
    }

    /**
     * @return string[]
     */
    public function getAvailablePairs(): array
    {
        return ['EUR-UAH', 'USD-UAH'];
    }
}