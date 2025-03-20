<?php

declare(strict_types=1);

namespace App\Service;

use App\Providers\PriceProviderInterface;
use Predis\Client;
use Symfony\Component\DependencyInjection\Attribute\AutowireInline;

class PriceUpdaterService
{
    public function __construct(
        private Client $predisClient,
    ) {
    }

    /**
     * @param PriceProviderInterface[] $providers
     * @return void
     */
    public function updateRedisKeys(array $providers): void
    {
        foreach ($providers as $provider) {
            $this->updatePrice($provider);
        }
    }

    public function updatePrice(PriceProviderInterface $provider): void
    {
        $prices = $provider->getPrices();

        foreach ($prices as $price) {
            [$pair, $price] = $price;
            $this->predisClient->set($pair, $price);
        }
    }
}
