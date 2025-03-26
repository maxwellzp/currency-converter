<?php

namespace App\Tests\Unit\Providers;

use App\Providers\BinanceProvider;
use App\Service\ApiService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BinanceProvider::class)]
class BinanceProviderTest extends TestCase
{
    private BinanceProvider $provider;
    protected function setUp(): void
    {
        parent::setUp();

        $apiService = new ApiService($this->createGuzzleClient(200, ProviderResponse::BINANCE));
        $this->provider = new BinanceProvider($apiService);
    }

    public function testGetMarketRatesWithCorrectJsonReturnsMarketRates()
    {
        $marketRates = $this->provider->getMarketRates();
        $this->assertIsArray($marketRates);
        $this->assertGreaterThan(0, count($marketRates));
    }

    public function testGetAvailablePairsReturnsNotEmptyArray()
    {
        $marketPairs = $this->provider->getAvailablePairs();
        $this->assertIsArray($marketPairs);
        $this->assertGreaterThan(0, count($marketPairs));
    }

    public function testGetNameReturnsNotEmptyString()
    {
        $actualResult = $this->provider->getName();
        $this->assertIsString($actualResult);
        $this->assertNotEmpty($actualResult);
    }

    private function createGuzzleClient(int $code, string $response)
    {
        $mock = new MockHandler([
            new Response($code, [], $response)
        ]);

        $handlerStack = HandlerStack::create($mock);
        return new Client(['handler' => $handlerStack]);
    }
}
