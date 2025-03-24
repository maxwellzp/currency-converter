<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utils;

use Alcohol\ISO4217;
use App\Utils\CurrencyHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CurrencyHelper::class)]
class CurrencyHelperTest extends TestCase
{
    private CurrencyHelper $currencyHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->currencyHelper = new CurrencyHelper(new ISO4217());
    }

    #[DataProvider('currencyAlpha3AndCodeProvider')]
    public function testCanGetCurrencyNameByCode(string $expectedAlphabeticCode, int $numericCurrencyCode)
    {
        $actualValue = $this->currencyHelper->getCurrencyAlpha3ByCode($numericCurrencyCode);

        $this->assertSame($expectedAlphabeticCode, $actualValue);
    }


    public static function currencyAlpha3AndCodeProvider(): array
    {
        return [
            'US Dollar' => ['USD', 840],
            'Ukrainian Hryvnia' => ['UAH', 980],
            'Euro' => ['EUR', 978],
            'Albanian Lek' => ['ALL', 8],
            'Australian Dollar' => ['AUD', 36],
        ];
    }


    #[DataProvider('currencyNameAndCodeProvider')]
    public function testCanGetCurrencyNameByAlpha3(string $expectedCurrencyName, string $alpha3)
    {
        $actualCurrencyName = $this->currencyHelper->getCurrencyNameByAlpha3($alpha3);
        $this->assertSame($expectedCurrencyName, $actualCurrencyName);
    }

    public static function currencyNameAndCodeProvider(): array
    {
        return [
            'US Dollar' => ['US Dollar', 'USD'],
            'Ukrainian Hryvnia' => ['Ukrainian Hryvnia', 'UAH'],
            'Euro' => ['Euro', 'EUR'],
            'Albanian Lek' => ['Albanian Lek', 'ALL'],
            'Australian Dollar' => ['Australian Dollar', 'AUD'],
        ];
    }

    public function testCannotGetCurrencyNameSoExceptionThrown()
    {
        $this->expectException(\DomainException::class);
        $this->currencyHelper->getCurrencyNameByAlpha3("FAKE ALPHA3");
    }

    public function testCannotGetCurrencyAlpha3ByCodeSoExceptionThrown()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->currencyHelper->getCurrencyAlpha3ByCode(1000);
    }
}
