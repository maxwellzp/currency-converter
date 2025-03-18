<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CurrencyConverterService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:currency-converter',
    description: 'A simple CLI currency converter',
)]
class CurrencyConverterCommand extends Command
{
    public function __construct(
        private readonly CurrencyConverterService $currencyConverterService
    )
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
        $result = $this->currencyConverterService->convert($amount, $from, $to);
        $io->success(sprintf("Conversion result: %s %s", $result, $to));

        return Command::SUCCESS;
    }
}
