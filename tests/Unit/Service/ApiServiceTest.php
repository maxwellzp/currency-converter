<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\ApiService;
use App\Tests\Unit\Providers\ProviderResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiService::class)]
class ApiServiceTest extends TestCase
{
    private ApiService $apiService;
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testFetchDataWithMockReturnsCorrectJson()
    {
        $guzzleClient = $this->createGuzzleClient(200, ProviderResponse::BINANCE);
        $this->apiService = new ApiService($guzzleClient);

        [$statusCode, $json] = $this->apiService->fetchData('https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT');

        $this->assertEquals(200, $statusCode);
        $this->assertNotEmpty($json);
        $this->assertJson($json);
        $this->assertEquals(ProviderResponse::BINANCE, $json);
    }

    public function testFetchDataWithInvalidApiUrlThrowsException()
    {
        $guzzleClient = $this->createGuzzleClient(404, '');
        $this->apiService = new ApiService($guzzleClient);

        $this->expectException(GuzzleException::class);

        $this->apiService->fetchData('not valid url');
    }

    public function createGuzzleClient(int $code, string $response)
    {
        $mock = new MockHandler([
            new Response($code, [], $response)
        ]);

        $handlerStack = HandlerStack::create($mock);
        return new Client(['handler' => $handlerStack]);
    }
}