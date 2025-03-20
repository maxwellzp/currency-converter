<?php

declare(strict_types=1);

namespace App\Command;

use App\Providers\BinanceProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;
use App\Service\PriceUpdaterService;
use GuzzleHttp\Client as GuzzleClient;
use Predis\Client as PredisClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:currency-updater',
    description: 'Command to update exchange rates in Redis',
)]
class CurrencyUpdaterCommand extends Command
{
    private PriceUpdaterService $priceUpdater;
    public function __construct()
    {
        parent::__construct();
        $client = new PredisClient();
        $this->priceUpdater = new PriceUpdaterService($client);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $guzzle = new GuzzleClient();
        $this->priceUpdater->updateRedisKeys([
            new NBUProvider($guzzle),
            new BinanceProvider($guzzle),
            new PrivatBankProvider($guzzle),
        ]);

        return Command::SUCCESS;
    }
}
