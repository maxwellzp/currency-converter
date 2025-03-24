<?php

namespace App\Tests\Unit\Utils;

use App\Model\CurrencyConfig;
use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PriceProviderInterface;
use App\Providers\PrivatBankProvider;
use App\Utils\CurrencyList;
use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CurrencyList::class)]
class CurrencyListTest extends TestCase
{
    private CurrencyList $currencyList;

    protected function setUp(): void
    {
        parent::setUp();
        $guzzle = new GuzzleClient();
        $this->currencyList = new CurrencyList([
            new NBUProvider($guzzle),
            new BinanceProvider($guzzle),
            new PrivatBankProvider($guzzle),
            new MonobankProvider($guzzle),
        ]);
    }

    public function testGetAllMarketsReturnsArrayOfMarkets()
    {
        $actualMarkets = $this->currencyList->getAllMarkets();

        $this->assertIsArray($actualMarkets);

        $expectedCount = 0;
        foreach ($this->currencyList->getProviders() as $provider) {
            $expectedCount += count($provider->getAvailablePairs());
        }

        $this->assertCount($expectedCount, $actualMarkets);
    }

    public function testGetCurrencyFromListReturnsArray()
    {
        $currencyList = $this->currencyList->getCurrencyFromList();

        $this->assertIsArray($currencyList);
        $this->assertNotEmpty($currencyList);
        $this->assertContainsOnlyString($currencyList);
    }

    #[DataProvider('alpha3Provider')]
    public function testGetCurrencyToListReturnsCurrencies($alpha3)
    {
        $currencies = $this->currencyList->getCurrencyToList($alpha3);
        $this->assertIsArray($currencies);
        $this->assertNotEmpty($currencies);
        $this->assertContainsOnlyString($currencies);
    }

    public static function alpha3Provider(): array
    {
        return [
            'UAH' => ['UAH'],
            'USD' => ['USD'],
            'EUR' => ['EUR'],
            'AUD' => ['AUD'],
            'CAD' => ['CAD'],
        ];
    }

    public function testCreateCurrencyConfigsReturnsResult()
    {
        $actualMarkets = $this->currencyList->getAllMarkets();
        $this->currencyList->createCurrencyConfigs($actualMarkets);

        $configs = $this->currencyList->getConfigurations();
        $this->assertIsArray($configs);
        $this->assertNotEmpty($configs);
        $this->assertContainsOnlyInstancesOf(CurrencyConfig::class, $configs);
    }

    public function testTransformMarketToCurrenciesWorksProperly()
    {
        $actualResult = $this->currencyList->transformMarketToCurrencies('USD-UAH');
        $this->assertIsArray($actualResult);
        $this->assertNotEmpty($actualResult);
        $this->assertCount(2, $actualResult);
        $this->assertSame('USD', $actualResult[0]);
        $this->assertSame('UAH', $actualResult[1]);
    }

    public function testGetProvidersReturnsNotEmptyArray()
    {
        $providers = $this->currencyList->getProviders();
        $this->assertIsArray($providers);
        $this->assertNotEmpty($providers);
        $this->assertContainsOnlyInstancesOf(PriceProviderInterface::class, $providers);
    }
}
