<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utils;

use Alcohol\ISO4217;
use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;
use App\Service\ApiService;
use App\Utils\CurrencyFormConfigurator;
use App\Utils\CurrencyHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CurrencyFormConfigurator::class)]
class CurrencyFormConfiguratorTest extends TestCase
{
    private CurrencyFormConfigurator $currencyFormConfigurator;
    protected function setUp(): void
    {
        parent::setUp();

        $apiService = new ApiService($this->createGuzzleClient(200, ''));

        $this->currencyFormConfigurator = new CurrencyFormConfigurator(
            new BinanceProvider($apiService),
            new MonobankProvider($apiService, new CurrencyHelper(new ISO4217())),
            new NBUProvider($apiService),
            new PrivatBankProvider($apiService),
        );
    }

    public function testGetConfigurationsReturnsArray()
    {
        $actualResult = $this->currencyFormConfigurator->getConfigurations();

        $this->assertIsArray($actualResult);
    }

    public function testGetCurrencyFromListReturnsArray()
    {
        $actualList = $this->currencyFormConfigurator->getCurrencyFromList();
        $this->assertIsArray($actualList);
    }

    public function testGetCurrencyToListReturnsArray()
    {
        $actualList = $this->currencyFormConfigurator->getCurrencyToList('USD');
        $this->assertIsArray($actualList);
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
