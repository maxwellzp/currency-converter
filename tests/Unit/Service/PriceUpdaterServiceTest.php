<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use Alcohol\ISO4217;
use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;
use App\Service\ApiService;
use App\Service\PriceUpdaterService;
use App\Service\RedisService;
use App\Tests\Unit\Providers\ProviderResponse;
use App\Utils\CurrencyHelper;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Predis\Client;

class PriceUpdaterServiceTest extends TestCase
{
    private PriceUpdaterService $priceUpdaterService;

    protected function setUp(): void
    {
        parent::setUp();

        $binanceApiService = new ApiService($this->createGuzzleClient('binance'));
        $monobankApiService = new ApiService($this->createGuzzleClient('monobank'));
        $nbuApiService = new ApiService($this->createGuzzleClient('nbu'));
        $privatBankApiService = new ApiService($this->createGuzzleClient('privatBank'));

        $binanceProvider = new BinanceProvider($binanceApiService);
        $monobankProvider = new MonobankProvider($monobankApiService, new CurrencyHelper(new ISO4217()));
        $nbuProvider = new NBUProvider($nbuApiService);
        $privatBankProvider = new PrivatBankProvider($privatBankApiService);

        $exactly
            = count($binanceProvider->getAvailablePairs())
            + count($monobankProvider->getAvailablePairs())
            + count($nbuProvider->getAvailablePairs())
            + count($privatBankProvider->getAvailablePairs());
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->exactly($exactly))
            ->method('__call')
            ->with(
                $this->equalTo('set'),
            );

        $redisService = new RedisService($predisClient);

        $this->priceUpdaterService = new PriceUpdaterService(
            $redisService,
            $binanceProvider,
            $monobankProvider,
            $nbuProvider,
            $privatBankProvider
        );
    }

    public function testUpdateWorksCorrectly(): void
    {
        $this->priceUpdaterService->update();
    }

    private function createGuzzleClient(string $provider)
    {
        $mock = match ($provider) {
            'binance' => new MockHandler([
                new Response(200, [], ProviderResponse::BINANCE),
            ]),
            'monobank' => new MockHandler([
                new Response(200, [], ProviderResponse::MONOBANK),
            ]),
            'nbu' => new MockHandler([
                new Response(200, [], ProviderResponse::NBU),
            ]),
            'privatBank' => new MockHandler([
                new Response(200, [], ProviderResponse::PRIVATBANK),
            ]),
        };

        $handlerStack = HandlerStack::create($mock);
        return new GuzzleClient(['handler' => $handlerStack]);
    }
}
