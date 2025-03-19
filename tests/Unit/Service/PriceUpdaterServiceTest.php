<?php

namespace App\Tests\Unit\Service;

use App\Providers\BinanceProvider;
use App\Service\PriceUpdaterService;
use PHPUnit\Framework\TestCase;
use Predis\Client;
use GuzzleHttp\Client as GuzzleClient;

class PriceUpdaterServiceTest extends TestCase
{
    private PriceUpdaterService $service;
    protected function setUp(): void
    {
        parent::setUp();
        $predisClient = new Client();

        $this->service = new PriceUpdaterService($predisClient);
    }

    public function testUpdatePrice()
    {
        $guzzleClient = new GuzzleClient();
        $binanceProvider = new BinanceProvider($guzzleClient);
        $this->service->updatePrice($binanceProvider);


    }
}