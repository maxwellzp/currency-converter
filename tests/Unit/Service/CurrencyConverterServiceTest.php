<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\CurrencyConverterService;
use App\Service\RedisService;
use PHPUnit\Framework\TestCase;
use Predis\Client;
use Predis\ClientInterface;

class CurrencyConverterServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCanConvert()
    {
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(['BTC-USD'])
            )
            ->willReturn('83659.99000000');

        $redisService = new RedisService($predisClient);
        $service = new CurrencyConverterService($redisService);
        $conversionResult = $service->convert(strval(10), 'BTC', 'USD');
        $expectedResult = 10 * 83659.99000000;
        $this->assertNotNull($conversionResult);
        $this->assertSame($expectedResult, $conversionResult);
    }

    public function testCannotConvert()
    {
        $predisClient = $this->createMock(Client::class);
        $invokedCount = $this->exactly(3);

        $predisClient
            ->expects($invokedCount)
            ->method('__call')
            ->with(
                $this->equalTo('get'),
            )
            ->willReturnCallback(function ($parameters, $commandArguments) use ($invokedCount) {

                $marketPair = $commandArguments[0];

                if ($invokedCount->numberOfInvocations() === 1) {
                    // the first call
                    // argument: AAA-ZZZ
//                    var_dump(["The first call", $marketPair]);
                    return null;
                }

                if ($invokedCount->numberOfInvocations() === 2) {
                    // the second call
                    // argument: ZZZ-AAA
//                    var_dump(["The second call", $marketPair]);
                    return null;
                }

                if ($invokedCount->numberOfInvocations() === 3) {
                    // the third call
                    // argument: AAA-USD
//                    var_dump(["The third call", $marketPair]);
                }
            });
        ;
        $currencyA = 'AAA';
        $currencyB = 'ZZZ';
        $redisService = new RedisService($predisClient);
        $service = new CurrencyConverterService($redisService);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('There is no exchange rate for %s-%s', $currencyA, $currencyB));
        $service->convert(strval(10), 'AAA', 'ZZZ');
    }

    public function testCanFetchExchangeRateFromRedis()
    {
        $expectedPrice = '83659.99000000';
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(['BTC-USD'])
            )
            ->willReturn('83659.99000000');
        $redisService = new RedisService($predisClient);
        $service = new CurrencyConverterService($redisService);
        $actualPriceFromRedis = $service->fetchFromRedis('BTC-USD');

        $this->assertIsString($actualPriceFromRedis);
        $this->assertNotEmpty($actualPriceFromRedis);
        $this->assertSame($expectedPrice, $actualPriceFromRedis);
    }

    public function testCannotFetchExchangeRateFromRedis()
    {
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(['AAA-ZZZ'])
            )
            ->willReturn(null);
        $redisService = new RedisService($predisClient);
        $service = new CurrencyConverterService($redisService);
        $valueFromRedis = $service->fetchFromRedis('AAA-ZZZ');
        $this->assertNull($valueFromRedis);
    }

    public function testDirectExchangeRateWorksCorrectly()
    {
        $expectedPrice = '83659.99000000';
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(['BTC-USD'])
            )
            ->willReturn($expectedPrice);
        $redisService = new RedisService($predisClient);
        $service = new CurrencyConverterService($redisService);
        $actualRate = $service->directExchangeRate('BTC', 'USD');
        $this->assertNotNull($actualRate);
        $this->assertIsString($actualRate);
        $this->assertSame($expectedPrice, $actualRate);
    }

    public function testIndirectExchangeRateWorksCorrectly()
    {
        $currentRate = '83659.99000000';
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(['BTC-USD'])
            )
            ->willReturn($currentRate);
        $redisService = new RedisService($predisClient);
        $service = new CurrencyConverterService($redisService);
        $actualRate = $service->indirectExchangeRate('BTC', 'USD');
        $this->assertNotNull($actualRate);
        $this->assertIsString($actualRate);
        $expectedRate = strval(1 / $currentRate);
        $this->assertSame($expectedRate, $actualRate);
    }

    public function testCrossExchangeRateWorksCorrectly()
    {
        $btcToUsd = '83331.03';
        $usdToUah = '41.43';
        $predisClient = $this->createMock(Client::class);
        $invokedCount = $this->exactly(2);

        $predisClient
            ->expects($invokedCount)
            ->method('__call')
            ->with(
                $this->equalTo('get'),
            )
            ->willReturnCallback(function ($parameters, $commandArguments) use ($invokedCount, $btcToUsd, $usdToUah) {

                $marketPair = $commandArguments[0];

                if ($invokedCount->numberOfInvocations() === 1) {
                    // the first call
                    // argument: BTC-USD
//                    var_dump(["The first call", $marketPair]);
                    return $btcToUsd;
                }

                if ($invokedCount->numberOfInvocations() === 2) {
                    // the second call
                    // argument: USD-UAH
//                    var_dump(["The second call", $marketPair]);
                    return $usdToUah;
                }
            });
        ;

        $redisService = new RedisService($predisClient);
        $service = new CurrencyConverterService($redisService);
        $actualRate = $service->crossExchangeRate('BTC', 'UAH');
        $this->assertNotNull($actualRate);
        $this->assertIsFloat($actualRate);
        $expectedRate = $btcToUsd * $usdToUah;
        $this->assertSame($expectedRate, $actualRate);
    }
}
