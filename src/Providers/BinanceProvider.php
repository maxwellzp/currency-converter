<?php

declare(strict_types=1);

namespace App\Providers;

use App\Service\ApiService;

class BinanceProvider implements PriceProviderInterface
{
    public const API_URL = 'https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT';

    public function __construct(private ApiService $apiService)
    {

    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getMarketRates(): array
    {
        [$code, $json] = $this->apiService->fetchData(self::API_URL);
        return $this->parsingResponse($json);
    }

    /**
     * @param string $json
     * @return array
     */
    private function parsingResponse(string $json): array
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
