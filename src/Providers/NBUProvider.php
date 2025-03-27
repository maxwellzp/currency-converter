<?php

declare(strict_types=1);

namespace App\Providers;

use App\Service\ApiService;

// https://bank.gov.ua/ua/open-data/api-dev
class NBUProvider implements PriceProviderInterface
{
    public const API_URL = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';

    public function __construct(private readonly ApiService $apiService)
    {
    }

    /**
     * @return array<string,mixed>
     * @throws \Exception
     */
    public function getMarketRates(): array
    {
        [$code, $json] = $this->apiService->fetchData(self::API_URL);
        return $this->parsingResponse($json);
    }

    /**
     * @param string $json
     * @return array<string,mixed>
     */
    public function parsingResponse(string $json): array
    {
        $result = [];
        $rates = json_decode($json, true);

        foreach ($rates as $rate) {
            $pair = sprintf("%s-%s", $rate['cc'], 'UAH');
            $price = $rate['rate'];
            $result[$pair] = [$pair, $price];
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "nbu";
    }

    /**
     * @return string[]
     */
    public function getAvailablePairs(): array
    {
        return [
            "AUD-UAH",
            "CAD-UAH",
            "CNY-UAH",
            "CZK-UAH",
            "DKK-UAH",
            "HKD-UAH",
            "HUF-UAH",
            "INR-UAH",
            "IDR-UAH",
            "ILS-UAH",
            "JPY-UAH",
            "KZT-UAH",
            "KRW-UAH",
            "MXN-UAH",
            "MDL-UAH",
            "NZD-UAH",
            "NOK-UAH",
            "RUB-UAH",
            "SGD-UAH",
            "ZAR-UAH",
            "SEK-UAH",
            "CHF-UAH",
            "EGP-UAH",
            "GBP-UAH",
            "USD-UAH",
            "BYN-UAH",
            "AZN-UAH",
            "RON-UAH",
            "TRY-UAH",
            "BGN-UAH",
            "EUR-UAH",
            "PLN-UAH",
            "DZD-UAH",
            "BDT-UAH",
            "AMD-UAH",
            "DOP-UAH",
            "IRR-UAH",
            "IQD-UAH",
            "KGS-UAH",
            "LBP-UAH",
            "LYD-UAH",
            "MYR-UAH",
            "MAD-UAH",
            "PKR-UAH",
            "SAR-UAH",
            "VND-UAH",
            "THB-UAH",
            "AED-UAH",
            "TND-UAH",
            "UZS-UAH",
            "TWD-UAH",
            "TMT-UAH",
            "RSD-UAH",
            "TJS-UAH",
            "GEL-UAH",
            "BRL-UAH",
        ];
    }
}
