<?php

namespace App\Twig\Components;

use App\Service\CurrencyConverterService;
use App\Utils\CurrencyFormConfigurator;
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
        private readonly LoggerInterface $logger,
    ) {
        $this->logger->critical('Initial values: ', [
            'amount' => $this->amount,
            'currencyFrom' => $this->currencyFrom,
            'currencyTo' => $this->currencyTo,
        ]);
    }

    #[LiveProp(writable: true)]
    public int $amount = 1;

    #[LiveProp(writable: true, onUpdated: 'onSelectUpdated')]
    public string $currencyFrom = 'BTC';

    #[LiveProp(writable: true)]
    public string $currencyTo = 'USD';

    public function onSelectUpdated(): void
    {
        $configurator = new CurrencyFormConfigurator();
        $this->currencyTo = $configurator->getCurrencyToList($this->currencyFrom)[0];
    }

    /**
     * @return string
     * @throws \Exception
     */
    #[LiveAction]
    public function calculateConversion(): string
    {
        $this->logger->critical('calculateConversion values: ', [
            'amount' => $this->amount,
            'currencyFrom' => $this->currencyFrom,
            'currencyTo' => $this->currencyTo,
        ]);

        $result = 0;
        try{
            $result = $this->currencyConverterService->convert(
                $this->amount,
                $this->currencyFrom,
                $this->currencyTo,
            );
        }catch (\Exception $exception){
            $this->logger->critical($exception->getMessage());
        }

        return $result;
    }


    #[LiveAction]
    public function getFromCurrencies(): array
    {
        $configurator = new CurrencyFormConfigurator();
        return $configurator->getCurrencyFromList();
    }


    #[LiveAction]
    public function getToCurrencies(): array
    {
        $configurator = new CurrencyFormConfigurator();
        return $configurator->getCurrencyToList($this->currencyFrom);
    }

    /**
     * @return string
     */
    public function getResultString(): string
    {
        return sprintf("%s %s", $this->calculateConversion(), $this->currencyTo);
    }
}
