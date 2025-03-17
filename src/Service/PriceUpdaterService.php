<?php

declare(strict_types=1);

namespace App\Service;

use App\Providers\PriceProviderInterface;
use Predis\Client;
use Symfony\Component\DependencyInjection\Attribute\AutowireInline;

class PriceUpdaterService
{
    public function __construct(
        #[AutowireInline(class: 'Predis\Client')]
        private Client $predisClient,
    )
    {
        $this->predisClient->set('test', '1010');
    }

    public function updateRedisKeys(array $providers): void
    {
        foreach ($providers as $provider) {
            $this->updatePrice($provider);
        }
    }

    public function updatePrice(PriceProviderInterface $provider): void
    {
        foreach ($provider->getAvailablePairs() as $pair) {
            $price = $provider->getPrice();
            $this->predisClient->set($pair, $price);
        }
    }
}
