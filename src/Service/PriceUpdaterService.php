<?php

declare(strict_types=1);

namespace App\Service;

use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PriceProviderInterface;
use App\Providers\PrivatBankProvider;

class PriceUpdaterService
{
    public function __construct(
        private RedisService $redisService,
        private BinanceProvider $binanceProvider,
        private MonobankProvider $monobankProvider,
        private NBUProvider $nbuProvider,
        private PrivatBankProvider $privatBankProvider,
    ) {
    }


    public function update(): void
    {
        $providers = [
            $this->binanceProvider,
            $this->monobankProvider,
            $this->nbuProvider,
            $this->privatBankProvider
        ];
        foreach ($providers as $provider) {
            $this->updatePrice($provider);
        }
    }

    public function updatePrice(PriceProviderInterface $provider): void
    {
        $prices = $provider->getPrices();

        foreach ($prices as $price) {
            [$pair, $price] = $price;
            $this->redisService->set($pair, (string)$price);
        }
    }
}
