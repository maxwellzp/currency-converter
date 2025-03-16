<?php

declare(strict_types=1);

namespace App\Service;

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

    public function updateRedisDb(): void
    {
        $this->predisClient->set('btc-usd', '1');
        $value = $this->predisClient->get('btc-usd');
    }

    public function updatePrice(): void
    {

    }
}