<?php

declare(strict_types=1);

namespace App\Command;

use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test-currency-converter',
    description: 'Add a short description for your command',
)]
class TestCurrencyConverterCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        $json = '{"symbol":"BTCUSDT","price":"83168.32000000"}';
        $binanceProvider = new BinanceProvider();
        $r = $binanceProvider->makeApiRequest();
        echo $r . PHP_EOL;

//        $nbuProvider = new NBUProvider();
//        $nbuProvider->getPrice();

//        $monobankProvider = new MonobankProvider();
//        $monobankProvider->getPrice();

//        $json = '[{"ccy":"EUR","base_ccy":"UAH","buy":"44.40000","sale":"45.40000"},{"ccy":"USD","base_ccy":"UAH","buy":"41.00000","sale":"41.60000"}]';

//        $rates = json_decode($json, true);
//
//        foreach ($rates as $rate) {
//            echo '-----------------------' . PHP_EOL;
//            echo $rate['ccy'] . PHP_EOL;
//            echo $rate['base_ccy'] . PHP_EOL;
//            echo $rate['buy'] . PHP_EOL;
//            echo $rate['sale'] . PHP_EOL;
//        }

//        $privatBankProvider = new PrivatBankProvider();
//        $r = $privatBankProvider->parsingResponse($json);
//        var_dump($r);

        return Command::SUCCESS;
    }
}
