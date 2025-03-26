<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Alcohol\ISO4217;
use App\Command\CurrencyUpdaterCommand;
use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;
use App\Service\ApiService;
use App\Service\PriceUpdaterService;
use App\Tests\Unit\Providers\ProviderResponse;
use App\Utils\CurrencyHelper;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\RedisService;
use PHPUnit\Framework\Attributes\CoversClass;
use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

#[CoversClass(CurrencyUpdaterCommand::class)]
class CurrencyUpdaterCommandTest extends KernelTestCase
{
    public function testSomething(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $binanceApiService = new ApiService($this->createGuzzleClient('binance'));
        $monobankApiService = new ApiService($this->createGuzzleClient('monobank'));
        $nbuApiService = new ApiService($this->createGuzzleClient('nbu'));
        $privatBankApiService = new ApiService($this->createGuzzleClient('privatBank'));

        $binanceProvider = new BinanceProvider($binanceApiService);
        $monobankProvider = new MonobankProvider($monobankApiService, new CurrencyHelper(new ISO4217()));
        $nbuProvider = new NBUProvider($nbuApiService);
        $privatBankProvider = new PrivatBankProvider($privatBankApiService);

        $redisService = new RedisService($this->createPredisClient());

        /** @var PriceUpdaterService $priceUpdaterService */
        $priceUpdaterService = new PriceUpdaterService(
            $redisService,
            $binanceProvider,
            $monobankProvider,
            $nbuProvider,
            $privatBankProvider,
        );

        self::getContainer()->set(PriceUpdaterService::class, $priceUpdaterService);

        $command = $application->find('app:currency-updater');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
    }

    private function createGuzzleClient(string $provider)
    {
        $mock =  match ($provider) {
            'binance' => new MockHandler([
                new Response(200, [], ProviderResponse::BINANCE),
            ]),
            'monobank' => new MockHandler([
                new Response(200, [], ProviderResponse::MONOBANK),
            ]),
            'nbu' => new MockHandler([
                new Response(200, [], ProviderResponse::NBU),
            ]),
            'privatBank' => new MockHandler([
                new Response(200, [], ProviderResponse::PRIVATBANK),
            ]),
        };

        $handlerStack = HandlerStack::create($mock);
        return new \GuzzleHttp\Client(['handler' => $handlerStack]);
    }

    private function createPredisClient(): Client
    {
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->any())
            ->method('__call')
            ->with(
                $this->equalTo('set'),
            );
        return $predisClient;
    }
}
