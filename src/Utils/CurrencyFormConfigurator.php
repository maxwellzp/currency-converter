<?php

declare(strict_types=1);

namespace App\Utils;

use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;

class CurrencyFormConfigurator
{
    private CurrencyList $currencyList;

    public function __construct(
        private BinanceProvider $binanceProvider,
        private MonobankProvider $monobankProvider,
        private NBUProvider $nbuProvider,
        private PrivatBankProvider $privatBankProvider,
    ) {
        $this->currencyList = new CurrencyList([
            $this->binanceProvider,
            $this->monobankProvider,
            $this->nbuProvider,
            $this->privatBankProvider,
        ]);
    }

    public function getCurrencyFromList(): array
    {
        return $this->currencyList->getCurrencyFromList();
    }

    public function getCurrencyToList(string $currency): array
    {
        return $this->currencyList->getCurrencyToList($currency);
    }

    public function getConfigurations(): array
    {
        return $this->currencyList->getConfigurations();
    }
}
