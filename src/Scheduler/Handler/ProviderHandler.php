<?php

namespace App\Scheduler\Handler;

use App\Providers\PriceProviderInterface;
use App\Scheduler\Message\ProviderMessage;
use App\Service\PriceUpdaterService;
use GuzzleHttp\Client as GuzzleClient;
use Predis\Client as PredisClient;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProviderHandler
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(ProviderMessage $test): void
    {
        $guzzleClient = new GuzzleClient();
        $predisClient = new PredisClient([
            'host' => $_ENV['REDIS_HOST'],
        ]);
        $className = $test->getClassName();
        /** @var PriceProviderInterface $provider */
        $provider = new $className($guzzleClient);
        $priceUpdater = new PriceUpdaterService($predisClient);
        $priceUpdater->updatePrice($provider);

        $this->logger->info('Service name: ' . $test->getClassName());
    }
}
