<?php

namespace App\Tests\Unit\Service;

use App\Service\CurrencyConverterService;
use PHPUnit\Framework\TestCase;
use Predis\Client;
use Predis\ClientInterface;

class CurrencyConverterServiceTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();


//        $predisClient = $this->createMock(ClientInterface::class);
//        $predisClient
//            ->expects($this->once())
//            ->method('__call')
//            ->with(
//                $this->equalTo('get'),
//                $this->equalTo(['BTC'])
//            )
//            ->willReturn('83659.99000000');
//
//
//
//        $myResult = $predisClient->get('BTC');
//        var_dump($myResult);



//        die();
//        $predisClient->set('BTC-USD', '83659.99000000');
//        $predisClient->set('USD-BTC', '0.000011958');
//        $predisClient->set('USD-UAH', '41.55');
//
//        $this->service = new CurrencyConverterService($predisClient);
    }

    public function testCanConvert()
    {
        $predisClient = $this->createMock(ClientInterface::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(['BTC-USD'])
            )
            ->willReturn('83659.99000000');


        $service = new CurrencyConverterService($predisClient);
        $conversionResult = $service->convert(10, 'BTC', 'USD');
        $expectedResult = 10 * 83659.99000000;
        $this->assertNotNull($conversionResult);
        $this->assertSame($expectedResult, $conversionResult);
    }

    public function testCannotConvert()
    {
        $predisClient = $this->createMock(ClientInterface::class);
        $invokedCount = $this->exactly(3);

        $predisClient
            ->expects($invokedCount)
            ->method('__call')
            ->with(
                $this->equalTo('get'),
            )
            ->willReturnCallback(function ($parameters, $commandArguments) use($invokedCount) {

                $marketPair = $commandArguments[0];

                if ($invokedCount->numberOfInvocations() === 1) {
                    // the first call
                    // argument: AAA-ZZZ
                    var_dump(["The first call", $marketPair]);
                    return null;
                }

                if ($invokedCount->numberOfInvocations() === 2) {
                    // the second call
                    // argument: ZZZ-AAA
                    var_dump(["The second call", $marketPair]);
                    return null;
                }

                if ($invokedCount->numberOfInvocations() === 3) {
                    // the third call
                    // argument: AAA-USD
                    var_dump(["The third call", $marketPair]);
                }
            });
        ;

        $service = new CurrencyConverterService($predisClient);
        $this->expectException(\Exception::class);
        $service->convert(10, 'AAA', 'ZZZ');
    }

//    public function testCanFetchExchangeRateFromRedis()
//    {
//        $predisClient = $this->createMock(ClientInterface::class);
//        $predisClient
//            ->expects($this->once())
//            ->method('__call')
//            ->with(
//                $this->equalTo('get'),
//                $this->equalTo(['BTC-USD'])
//            )
//            ->willReturn('83659.99000000');
//        $service = new CurrencyConverterService($predisClient);
//        $valueFromRedis = $service->fetchFromRedis('BTC-USD');
//
//        $this->assertIsString($valueFromRedis);
//        $this->assertNotEmpty($valueFromRedis);
//    }

//    public function testCannotFetchExchangeRateFromRedis()
//    {
//        $predisClient = $this->createMock(ClientInterface::class);
//        $predisClient
//            ->expects($this->once())
//            ->method('__call')
//            ->with(
//                $this->equalTo('get'),
//                $this->equalTo(['BTC-USD'])
//            )
//            ->willReturn('83659.99000000');
//        $service = new CurrencyConverterService($predisClient);
//        $valueFromRedis = $service->fetchFromRedis('XYZ');
//        $this->assertNull($valueFromRedis);
//    }

//    public function testDirectExchangeRateWorksCorrectly()
//    {
//        $rate = $this->service->directExchangeRate('BTC', 'USD');
//        $this->assertNotNull($rate);
//        $this->assertIsString($rate);
//    }
//
//    public function testIndirectExchangeRateWorksCorrectly()
//    {
//        $rate = $this->service->indirectExchangeRate('USD', 'BTC');
//        $this->assertNotNull($rate);
//        $this->assertIsString($rate);
//    }
//
//    public function testCrossExchangeRateWorksCorrectly()
//    {
//        $rate = $this->service->crossExchangeRate('BTC', 'BTC');
//        $this->assertNotNull($rate);
//        $this->assertIsFloat($rate);
//    }
}