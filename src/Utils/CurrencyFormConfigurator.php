<?php

declare(strict_types=1);

namespace App\Utils;

use App\Model\CurrencyConfig;
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

    /**
     * @return array<string,string>
     */
    public function getCurrencyFromList(): array
    {
        return $this->currencyList->getCurrencyFromList();
    }

    /**
     * @param string $currency
     * @return string[]
     * @throws \Exception
     */
    public function getCurrencyToList(string $currency): array
    {
        return $this->currencyList->getCurrencyToList($currency);
    }

    /**
     * @return array<string,CurrencyConfig>
     */
    public function getConfigurations(): array
    {
        return $this->currencyList->getConfigurations();
    }
}
