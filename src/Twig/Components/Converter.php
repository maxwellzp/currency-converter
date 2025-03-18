<?php

namespace App\Twig\Components;

use App\Service\CurrencyConverterService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Psr\Log\LoggerInterface;


#[AsLiveComponent]
class Converter
{
    use DefaultActionTrait;

    public function __construct(
        private readonly CurrencyConverterService $currencyConverterService,
        private readonly LoggerInterface          $logger,
    )
    {
        $this->logger->critical('Initial values: ', [
            'amount' => $this->amount,
            'currencyFrom' => $this->currencyFrom,
            'currencyTo' => $this->currencyTo,
        ]);
    }

    #[LiveProp(writable: true)]
    public int $amount = 1;

    #[LiveProp(writable: true)]
    public string $currencyFrom = 'BTC';

    #[LiveProp(writable: true)]
    public string $currencyTo = 'UAH';

    #[LiveAction]
    public function calculateConversion(): string
    {
        $this->logger->critical('calculateConversion values: ', [
            'amount' => $this->amount,
            'currencyFrom' => $this->currencyFrom,
            'currencyTo' => $this->currencyTo,
        ]);


        return $this->currencyConverterService->convert(
            $this->amount,
            $this->currencyFrom,
            $this->currencyTo,
        );
    }

    public function getFromCurrencies(): array
    {
        return ['BTC', 'USD', 'EUR', 'UAH'];
    }

    public function getToCurrencies(): array
    {
        return ['EUR', 'UAH'];
    }

    public function getResultString(): string
    {
        return sprintf("%s %s", $this->calculateConversion(), $this->currencyTo);
    }
}