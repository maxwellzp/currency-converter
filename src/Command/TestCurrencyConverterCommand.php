<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\CurrencyConfig;
use App\Utils\CurrencyFormConfigurator;
use App\Utils\CurrencyList;
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

        $configurator = new CurrencyFormConfigurator();
        /** @var CurrencyConfig[] $configs */
        $configs = $configurator->getConfigurations();
        foreach ($configs as $config) {
            $io->writeln(sprintf(
                "Base currency: %s",
                $config->getBaseCurrency()
                .
                "       " . implode(',', $config->getCounterCurrencies())
            ));
        }

        return Command::SUCCESS;
    }
}
