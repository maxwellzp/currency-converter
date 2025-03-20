<?php

namespace App\Tests\Unit\Utils;

use App\Utils\CurrencyHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CurrencyHelperTest extends TestCase
{
    #[DataProvider('currencyNameAndCodeProvider')]
    public function testCanGetCurrencyNameByCode(string $expectedAlphabeticCode, int $numericCurrencyCode)
    {
        $actualValue = CurrencyHelper::getCurrencyNameByCode($numericCurrencyCode);

        $this->assertSame($expectedAlphabeticCode, $actualValue);
    }


    public static function currencyNameAndCodeProvider(): array
    {
        return [
            'United States dollar' => ['USD', 840],
            'Ukrainian hryvnia' => ['UAH', 980],
            'Euro' => ['EUR', 978],
            'Albanian lek' => ['ALL', 8],
            'Australian dollar' => ['AUD', 36]
        ];
    }
}