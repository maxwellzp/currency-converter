<?php

namespace App\Twig\Components;

use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;
use App\Service\CurrencyConverterService;
use App\Utils\CurrencyList;
use GuzzleHttp\Client as GuzzleClient;
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

    #[LiveProp(writable: true)]
    public string $currencyFrom = 'BTC';

    #[LiveProp(writable: true)]
    public string $currencyTo = 'USD';

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
        $guzzle = new GuzzleClient();
        $currencyList = new CurrencyList([
            new NBUProvider($guzzle),
            new BinanceProvider($guzzle),
            new PrivatBankProvider($guzzle),
            new MonobankProvider($guzzle),
        ]);
        return $currencyList->getCurrencyFromList();
    }


    #[LiveAction]
    public function getToCurrencies(): array
    {
        $guzzle = new GuzzleClient();
        $currencyList = new CurrencyList([
            new NBUProvider($guzzle),
            new BinanceProvider($guzzle),
            new PrivatBankProvider($guzzle),
            new MonobankProvider($guzzle),
        ]);
        return $currencyList->getCurrencyToList($this->currencyFrom);
    }

    /**
     * @return string
     */
    public function getResultString(): string
    {
        return sprintf("%s %s", $this->calculateConversion(), $this->currencyTo);
    }
}
