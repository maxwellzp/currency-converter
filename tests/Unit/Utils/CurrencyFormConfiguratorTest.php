<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utils;

use App\Utils\CurrencyFormConfigurator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CurrencyFormConfigurator::class)]
class CurrencyFormConfiguratorTest extends TestCase
{
    private CurrencyFormConfigurator $currencyFormConfigurator;
    protected function setUp(): void
    {
        parent::setUp();
        $this->currencyFormConfigurator = new CurrencyFormConfigurator();
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
}