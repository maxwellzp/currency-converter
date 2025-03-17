<?php

namespace App\Twig\Components;

use App\Service\CurrencyConverterService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;


#[AsLiveComponent]
class Converter
{
    use DefaultActionTrait;

    public function __construct(
        private readonly CurrencyConverterService $currencyConverterService
    )
    {

    }

    #[LiveProp(writable: true)]
    public int $amount = 1;

    #[LiveProp(writable: true)]
    public string $currencyFrom = '';
    #[LiveProp(writable: true)]
    public string $currencyTo = '';

    #[LiveAction]
    public function getRate(): int
    {
        $amount = $this->currencyConverterService->convert(10, 'BTC', 'USD');
        return rand(10, 10000);
    }

    public function getFromCurrencies()
    {
        return ['BTC', 'USD', 'EUR', 'UAH'];
    }
    public function getToCurrencies()
    {
        return ['EUR', 'UAH'];
    }

    public function getResult(): string
    {
        return sprintf("%s %s", $this->getRate(), 'EUR');
    }
}