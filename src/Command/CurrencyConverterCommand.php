<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:currency-converter',
    description: 'Add a short description for your command',
)]
class CurrencyConverterCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount to convert')
            ->addArgument('from', InputArgument::REQUIRED, 'Currency from')
            ->addArgument('to', InputArgument::REQUIRED, 'Currency to')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $amount = $input->getArgument('amount');
        $from = $input->getArgument('from');
        $to = $input->getArgument('to');

        $io->writeln(sprintf("Convert %d %s to %s.", $amount, $from, $to));

        return Command::SUCCESS;
    }
}
