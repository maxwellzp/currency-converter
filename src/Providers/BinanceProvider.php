<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

class BinanceProvider extends BasePriceProvider implements PriceProviderInterface
{
    public const API_URL = 'https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPrices(): array
    {
        [$code, $json] = $this->makeApiRequest(self::API_URL);
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
