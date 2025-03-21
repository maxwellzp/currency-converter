<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

// https://api.privatbank.ua/#p24/exchange
class PrivatBankProvider extends BasePriceProvider implements PriceProviderInterface
{
    public const API_URL = 'https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5';

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
