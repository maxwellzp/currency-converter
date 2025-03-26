<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\PriceController;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

#[CoversClass(PriceController::class)]
class PriceControllerTest extends WebTestCase
{
    public function testIndexWithGetMethodReturnsCorrectHtml(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorCount(2, 'input.form-control');
        $this->assertSelectorCount(2, 'select.form-select');
        $this->assertSelectorExists('#amountElement');
        $this->assertSelectorExists('#currencyFromElement');
        $this->assertSelectorExists('#currencyToElement');
        $this->assertSelectorExists('#conversionResult');
    }

    public function testNonExistentPageReturns404Code(): void
    {
        $client = static::createClient();

        $client->request('GET', '/fakeroute');

        $this->assertResponseStatusCodeSame(404);
        $this->assertSelectorTextContains('html', 'Page not found');
    }
}
