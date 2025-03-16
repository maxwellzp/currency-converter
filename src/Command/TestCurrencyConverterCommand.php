<?php

namespace App\Command;

use App\Providers\BinanceProvider;
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

//        $privatBankProvider = new PrivatBankProvider();
//        $privatBankProvider->getPrice();

        $binanceProvider = new BinanceProvider();
        $binanceProvider->getPrice();


        return Command::SUCCESS;
    }
}
