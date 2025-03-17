<?php

declare(strict_types=1);

namespace App\Service;

use Predis\Client;
use Symfony\Component\DependencyInjection\Attribute\AutowireInline;

class CurrencyConverterService
{
    public function __construct(
        #[AutowireInline(class: 'Predis\Client')]
        private Client $predisClient,
    )
    {

    }

    public function convert(string $amount, string $currencyFrom, string $currencyTo): int
    {
        // ...
        $provider = 'someprovider';
        $key = sprintf('%s-%s', $provider, $currencyFrom, $currencyTo);
        $currencyRate = $this->fetchFromRedis($key);

        return 0;
    }

    public function fetchFromRedis(string $key): string|null
    {
        return $this->predisClient->get($key);
    }
}