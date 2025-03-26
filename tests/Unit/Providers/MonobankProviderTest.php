<?php

namespace App\Tests\Unit\Providers;

use Alcohol\ISO4217;
use App\Providers\MonobankProvider;
use App\Service\ApiService;
use App\Utils\CurrencyHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MonobankProvider::class)]
class MonobankProviderTest extends TestCase
{
    private MonobankProvider $provider;
    protected function setUp(): void
    {
        parent::setUp();

        $apiService = new ApiService($this->createGuzzleClient(200, ProviderResponse::MONOBANK));
        $this->provider = new MonobankProvider($apiService, new CurrencyHelper(new ISO4217()));
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