<?php

declare(strict_types=1);

namespace App\Command;

use App\Providers\BinanceProvider;
use App\Providers\PrivatBankProvider;
use App\Service\PriceUpdaterService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:currency-updater',
    description: 'Add a short description for your command',
)]
class CurrencyUpdaterCommand extends Command
{
    public function __construct(private PriceUpdaterService $priceUpdater)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->priceUpdater->updateRedisKeys([
            new BinanceProvider(),
            new PrivatBankProvider(),
        ]);

        return Command::SUCCESS;
    }
}
