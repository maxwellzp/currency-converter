<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

class BinanceProvider implements PriceProviderInterface
{
    private const API_URL = 'https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT';


    public function __construct(
        private Client $client
    )
    {

    }

    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function makeApiRequest(): array
    {
        $response = $this->client->request('GET', self::API_URL);
        $json = $response->getBody()->getContents();
        if (!json_validate($json)) {
            throw new \Exception('Json response is not valid');
        }
        return [$response->getStatusCode(), $json];
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
