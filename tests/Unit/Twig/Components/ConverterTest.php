<?php

namespace App\Tests\Unit\Twig\Components;

use App\Twig\Components\Converter;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;

#[CoversClass(Converter::class)]
class ConverterTest extends KernelTestCase
{
    use InteractsWithLiveComponents;

    public function testConverterCanRenderAndInteract(): void
    {
        $converterComponent = $this->createLiveComponent(
            name: Converter::class,
        );

        $this->assertStringContainsString('Amount', $converterComponent->render());
        $this->assertStringContainsString('Currency From', $converterComponent->render());
        $this->assertStringContainsString('Currency To', $converterComponent->render());
        $this->assertStringContainsString('Result', $converterComponent->render());

        $converterComponent->set('amount', '10');
        $converterComponent->set('currencyFrom', 'BTC');
        $converterComponent->set('currencyTo', 'USD');

        $this->assertStringContainsString('10', $converterComponent->render());
        $this->assertStringContainsString('BTC', $converterComponent->render());
        $this->assertStringContainsString('USD', $converterComponent->render());

        $converterComponent
            ->call('getResultString')
        ;

        $component = $converterComponent->component();
        $actualResult = $component->getResultString();
        $this->assertStringContainsString($actualResult, $converterComponent->render());
    }
}