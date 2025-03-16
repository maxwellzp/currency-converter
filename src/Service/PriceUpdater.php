<?php

declare(strict_types=1);

namespace App\Service;

use Predis\Client;

class PriceUpdater
{
    public function __construct(private Client $predisClient)
    {

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