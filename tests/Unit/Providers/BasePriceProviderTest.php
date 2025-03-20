<?php

declare(strict_types=1);

namespace App\Tests\Unit\Providers;

use GuzzleHttp\Exception\ServerException;
use App\Providers\PriceProviderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BasePriceProviderTest extends TestCase
{
    #[DataProvider('priceProvidersWithResponse')]
    public function testMakeApiRequestReturnsValidJson(string $providerClassName, string $correctJson)
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], $correctJson)
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        /** @var PriceProviderInterface $provider */
        $provider = new $providerClassName($client);
        [$statusCode, $json] = $provider->makeApiRequest($providerClassName::API_URL);

        $this->assertEquals(200, $statusCode);
        $this->assertNotEmpty($json);
        $this->assertJson($json);
        $this->assertEquals($correctJson, $json);
    }

    public static function priceProvidersWithResponse(): array
    {
        return [
            'binance' => ['App\Providers\BinanceProvider', ProviderResponse::BINANCE],
            'monobank' => ['App\Providers\MonobankProvider', ProviderResponse::MONOBANK],
            'NBU' => ['App\Providers\NBUProvider', ProviderResponse::NBU],
            'privatbank' => ['App\Providers\PrivatBankProvider', ProviderResponse::PRIVATBANK],
        ];
    }

    #[DataProvider('listOfPriceProviders')]
    public function testMakeApiRequestReturnsInvalidJson(string $providerClassName)
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], 'invalid json')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $provider = new $providerClassName($client);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Json response is not valid');
        [$statusCode, $json] = $provider->makeApiRequest($providerClassName::API_URL);

        $this->assertJson($json);
    }

    public static function listOfPriceProviders(): array
    {
        return [
            'binance' => ['App\Providers\BinanceProvider'],
            'monobank' => ['App\Providers\MonobankProvider'],
            'NBU' => ['App\Providers\NBUProvider'],
            'privatbank' => ['App\Providers\PrivatBankProvider'],
        ];
    }

    #[DataProvider('listOfPriceProviders')]
    public function testMakeApiRequestButServerApiIsDown(string $providerClassName)
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(500, [], 'Server error')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $provider = new $providerClassName($client);
        $this->expectException(ServerException::class);
        $provider->makeApiRequest($providerClassName::API_URL);
    }
}
