<?php

declare(strict_types=1);

namespace App\Scheduler\Handler;

use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;
use App\Scheduler\Message\ProviderMessage;
use App\Service\PriceUpdaterService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProviderHandler
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private PriceUpdaterService $priceUpdater,
        private BinanceProvider $binanceProvider,
        private MonobankProvider $monobankProvider,
        private NBUProvider $nbuProvider,
        private PrivatBankProvider $privatBankProvider,
    ) {
    }

    public function __invoke(ProviderMessage $test): void
    {
        $provider = match ($test->getClassName()) {
            BinanceProvider::class => $this->binanceProvider,
            MonobankProvider::class => $this->monobankProvider,
            NBUProvider::class => $this->nbuProvider,
            PrivatBankProvider::class => $this->privatBankProvider,
            default => throw new \Exception('Unexpected provider class: ' . $test->getClassName()),
        };

        $this->priceUpdater->updatePrice($provider);
        $this->logger->info('Service name: ' . $test->getClassName());
    }
}
