<?php

namespace App\Tests\Unit\Service;

use App\Service\CurrencyConverterService;
use PHPUnit\Framework\TestCase;
use Predis\Client;

class CurrencyConverterServiceTest extends TestCase
{
    private CurrencyConverterService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $predisClient = new Client();
        $predisClient->set('BTC-USD', '83659.99000000');
        $predisClient->set('USD-BTC', '0.000011958');
        $predisClient->set('USD-UAH', '41.55');

        $this->service = new CurrencyConverterService($predisClient);
    }

    public function testCanConvert()
    {
        $conversionResult = $this->service->convert(10, 'BTC', 'USD');
        $expectedResult = 10 * 83659.99000000;
        $this->assertNotNull($expectedResult);
        $this->assertSame($expectedResult, $conversionResult);
    }

    public function testCannotConvert()
    {
        $this->expectException(\Exception::class);
        $this->service->convert(10, 'XYZ', 'ZYX');
    }

    public function testCanFetchExchangeRateFromRedis()
    {
        $valueFromRedis = $this->service->fetchFromRedis('BTC-USD');
        $this->assertIsString($valueFromRedis);
        $this->assertNotEmpty($valueFromRedis);
    }

    public function testCannotFetchExchangeRateFromRedis()
    {
        $valueFromRedis = $this->service->fetchFromRedis('XYZ');
        $this->assertNull($valueFromRedis);
    }

    public function testDirectExchangeRateWorksCorrectly()
    {
        $rate = $this->service->directExchangeRate('BTC', 'USD');
        $this->assertNotNull($rate);
        $this->assertIsString($rate);
    }

    public function testIndirectExchangeRateWorksCorrectly()
    {
        $rate = $this->service->indirectExchangeRate('USD', 'BTC');
        $this->assertNotNull($rate);
        $this->assertIsString($rate);
    }

    public function testCrossExchangeRateWorksCorrectly()
    {
        $rate = $this->service->crossExchangeRate('BTC', 'BTC');
        $this->assertNotNull($rate);
        $this->assertIsFloat($rate);
    }
}