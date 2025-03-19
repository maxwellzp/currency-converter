<?php

namespace App\Tests\Unit\Providers;

use App\Providers\BinanceProvider;
use GuzzleHttp\Exception\ServerException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class BinanceProviderTest extends TestCase
{
    private BinanceProvider $provider;

    public function testMakeApiRequestReturnsValidJson()
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], $this->getCorrectJsonResponse())
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $provider = new BinanceProvider($client);
        [$statusCode, $json] = $provider->makeApiRequest();

        $this->assertEquals(200, $statusCode);
        $this->assertNotEmpty($json);
        $this->assertJson($json);
        $this->assertEquals($this->getCorrectJsonResponse(), $json);
    }

    public function testMakeApiRequestReturnsInvalidJson()
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], $this->getInvalidJsonResponse())
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $provider = new BinanceProvider($client);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Json response is not valid');
        [$statusCode, $json] = $provider->makeApiRequest();

        $this->assertJson($json);
    }

    public function testMakeApiRequestButServerApiIsDown()
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(500, [], 'Server error')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $provider = new BinanceProvider($client);
        $this->expectException(ServerException::class);
        $provider->makeApiRequest();
    }

    public function getCorrectJsonResponse(): string
    {
        return '{"symbol":"BTCUSDT","price":"83168.32000000"}';
    }

    public function getEmptyJsonResponse(): string
    {
        return '{}';
    }
    public function getInvalidJsonResponse(): string
    {
        return 'Abc..........';
    }
}