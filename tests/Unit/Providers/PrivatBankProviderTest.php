<?php

namespace App\Tests\Unit\Providers;

use App\Providers\PrivatBankProvider;
use App\Service\ApiService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PrivatBankProvider::class)]
class PrivatBankProviderTest extends TestCase
{
    private PrivatBankProvider $provider;
    protected function setUp(): void
    {
        parent::setUp();

        $apiService = new ApiService($this->createGuzzleClient(200, ProviderResponse::PRIVATBANK));
        $this->provider = new PrivatBankProvider($apiService);
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
