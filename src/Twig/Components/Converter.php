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
        private readonly CurrencyFormConfigurator $formConfigurator,
    ) {
        $this->currencyFrom = 'AED';

        $this->currencyTo = $this->formConfigurator->getCurrencyToList($this->currencyFrom)[0];
    }

    #[LiveProp(writable: true)]
    public float $amount = 1;

    #[LiveProp(writable: true, onUpdated: 'onSelectUpdated')]
    public string $currencyFrom;

    #[LiveProp(writable: true)]
    public string $currencyTo;

    public function onSelectUpdated(): void
    {
        $this->currencyTo = $this->formConfigurator->getCurrencyToList($this->currencyFrom)[0];
    }

    /**
     * @return string
     * @throws \Exception
     */
    #[LiveAction]
    public function calculateConversion(): string
    {
        $result = 0;
        try {
            $result = $this->currencyConverterService->convert(
                strval($this->amount),
                $this->currencyFrom,
                $this->currencyTo,
            );
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }
        return strval($result);
    }


    /**
     * @return array<string,string>
     */
    #[LiveAction]
    public function getFromCurrencies(): array
    {
        return $this->formConfigurator->getCurrencyFromList();
    }


    /**
     * @return array<string,string>
     */
    #[LiveAction]
    public function getToCurrencies(): array
    {
        return $this->formConfigurator->getCurrencyToList($this->currencyFrom);
    }

    /**
     * @return string
     * @throws \Exception
     */
    #[LiveAction]
    public function getResultString(): string
    {
        return sprintf("%s %s", $this->calculateConversion(), $this->currencyTo);
    }
}
