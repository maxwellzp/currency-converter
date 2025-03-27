<?php

declare(strict_types=1);

namespace App\Providers;

use App\Service\ApiService;
use App\Utils\CurrencyHelper;

// https://monobank.ua/api-docs/monobank/publichni-dani/get--bank--currency
class MonobankProvider implements PriceProviderInterface
{
    public const API_URL = 'https://api.monobank.ua/bank/currency';

    public function __construct(private ApiService $apiService, private CurrencyHelper $currencyHelper)
    {
    }

    /**
     * @param string $json
     * @return array<string,mixed>
     * @throws \Exception
     */
    public function parsingResponse(string $json): array
    {
        $result = [];
        $rates = json_decode($json, true);

        foreach ($rates as $rate) {
            $marketPair = $this->getMarketPairFromCurrencies($rate['currencyCodeA'], $rate['currencyCodeB']);

            $price = $this->getPriceFromJson($rate);

            $result[$marketPair] = [$marketPair, $price];
        }
        return $result;
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
     * @return string
     */
    public function getName(): string
    {
        return "monobank";
    }

    /**
     * @return string[]
     */
    public function getAvailablePairs(): array
    {
        return [
            'USD-UAH',
            'EUR-UAH',
            'EUR-USD',
            'GBP-UAH',
            'JPY-UAH',
            'CHF-UAH',
            'CNY-UAH',
            'AED-UAH',
            'AFN-UAH',
            'ALL-UAH',
            'AMD-UAH',
            'AOA-UAH',
            'ARS-UAH',
            'AUD-UAH',
            'AZN-UAH',
            'BDT-UAH',
            'BGN-UAH',
            'BHD-UAH',
            'BIF-UAH',
            'BND-UAH',
            'BOB-UAH',
            'BRL-UAH',
            'BWP-UAH',
            'BYN-UAH',
            'CAD-UAH',
            'CDF-UAH',
            'CLP-UAH',
            'COP-UAH',
            'CRC-UAH',
            'CUP-UAH',
            'CZK-UAH',
            'DJF-UAH',
            'DKK-UAH',
            'DZD-UAH',
            'EGP-UAH',
            'ETB-UAH',
            'GEL-UAH',
            'GHS-UAH',
            'GMD-UAH',
            'GNF-UAH',
            'HKD-UAH',
            'HRK-UAH',
            'HUF-UAH',
            'IDR-UAH',
            'ILS-UAH',
            'INR-UAH',
            'IQD-UAH',
            'ISK-UAH',
            'JOD-UAH',
            'KES-UAH',
            'KGS-UAH',
            'KHR-UAH',
            'KRW-UAH',
            'KWD-UAH',
            'KZT-UAH',
            'LAK-UAH',
            'LBP-UAH',
            'LKR-UAH',
            'LYD-UAH',
            'MAD-UAH',
            'MDL-UAH',
            'MGA-UAH',
            'MKD-UAH',
            'MNT-UAH',
            'MUR-UAH',
            'MWK-UAH',
            'MXN-UAH',
            'MYR-UAH',
            'MZN-UAH',
            'NAD-UAH',
            'NGN-UAH',
            'NIO-UAH',
            'NOK-UAH',
            'NPR-UAH',
            'NZD-UAH',
            'OMR-UAH',
            'PEN-UAH',
            'PHP-UAH',
            'PKR-UAH',
            'PLN-UAH',
            'PYG-UAH',
            'QAR-UAH',
            'RON-UAH',
            'RSD-UAH',
            'SAR-UAH',
            'SCR-UAH',
            'SDG-UAH',
            'SEK-UAH',
            'SGD-UAH',
            'SLL-UAH',
            'SOS-UAH',
            'SRD-UAH',
            'SZL-UAH',
            'THB-UAH',
            'TJS-UAH',
            'TND-UAH',
            'TRY-UAH',
            'TWD-UAH',
            'TZS-UAH',
            'UGX-UAH',
            'UYU-UAH',
            'UZS-UAH',
            'VND-UAH',
            'XAF-UAH',
            'XOF-UAH',
            'YER-UAH',
            'ZAR-UAH'
        ];
    }

    /**
     * @param int $currencyCodeA
     * @param int $currencyCodeB
     * @return string
     */
    public function getMarketPairFromCurrencies(int $currencyCodeA, int $currencyCodeB): string
    {
        $currencyA = $this->currencyHelper->getCurrencyAlpha3ByCode($currencyCodeA);
        $currencyB = $this->currencyHelper->getCurrencyAlpha3ByCode($currencyCodeB);

        return sprintf("%s-%s", $currencyA, $currencyB);
    }

    /**
     * @param array<string,float> $rateData
     * @return float
     * @throws \Exception
     */
    public function getPriceFromJson(array $rateData): float
    {
        if (array_key_exists('rateBuy', $rateData) && array_key_exists('rateSell', $rateData)) {
            $price = ($rateData['rateBuy'] * $rateData['rateSell']) / 2;
        } elseif (array_key_exists('rateCross', $rateData)) {
            $price = $rateData['rateCross'];
        } else {
            throw new \Exception('Invalid json format');
        }
        return $price;
    }
}
