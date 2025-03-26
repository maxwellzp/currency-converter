<?php

declare(strict_types=1);

namespace App\Tests\Unit\Twig\Extensions;

use Alcohol\ISO4217;
use App\Twig\Extensions\CurrencyNameExtension;
use App\Utils\CurrencyHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CurrencyNameExtension::class)]
class CurrencyNameExtensionTest extends TestCase
{
    private CurrencyNameExtension $extension;
    protected function setUp(): void
    {
        $iso4217 = new ISO4217();
        $helper = new CurrencyHelper($iso4217);
        $this->extension = new CurrencyNameExtension($helper);
    }

    #[DataProvider('currencyNameProvider')]
    public function testX(string $alpha3, string $currencyName): void
    {
        $actualName = $this->extension->currencyName($alpha3);
        $expectedName =  sprintf("%s (%s)", $alpha3, $currencyName);
        $this->assertSame($expectedName, $actualName);
    }

    public static function currencyNameProvider(): \Generator
    {
        yield 'AED' => ['AED', 'UAE Dirham'];
        yield 'GBP' => ['GBP', 'Pound Sterling'];
        yield 'UAH' => ['UAH', 'Ukrainian Hryvnia'];
        yield 'USD' => ['USD', 'US Dollar'];
        yield 'BTC' => ['BTC', 'Bitcoin'];
    }
}
