<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Command\CurrencyConverterCommand;
use App\Service\CurrencyConverterService;
use App\Service\RedisService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

#[CoversClass(CurrencyConverterCommand::class)]
class CurrencyConverterCommandTest extends KernelTestCase
{
    private const EXCHANGE_RATE = '83659.99000000';

    #[DataProvider('conversionExamplesProvider')]
    public function testExecute(string $amount, string $from, string $to, string $expectedConversionResult): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        $redisService = new RedisService($this->createPredisClient());
        $currencyConverterService = new CurrencyConverterService($redisService);

        $actualResult = $currencyConverterService->convert($amount, $from, $to);
        $actualString = sprintf("Conversion result: %s %s", $actualResult, $to);

        $expectedString = sprintf("Conversion result: %s %s", $expectedConversionResult, $to);

        $command = $application->find('app:currency-converter');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'amount' => $amount,
            'from' => $from,
            'to' => $to
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString($expectedString, $actualString);
    }

    public static function conversionExamplesProvider(): array
    {
        return [
            '1 BTC to USD' => [strval(1), 'BTC', 'USD', strval(1 * self::EXCHANGE_RATE)],
            '1.1 BTC to USD' => [strval(1.1), 'BTC', 'USD', strval(1.1 * self::EXCHANGE_RATE)],
            '10 BTC to USD' => [strval(10), 'BTC', 'USD', strval(10 * self::EXCHANGE_RATE)],
            '1.0 BTC to USD' => [strval(1.0), 'BTC', 'USD', strval(1.0 * self::EXCHANGE_RATE)],
        ];
    }

    public function testExecuteWithNoArgumentsThrowsException()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        $command = $application->find('app:currency-converter');
        $commandTester = new CommandTester($command);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "amount, from, to")');

        $commandTester->execute([]);
    }

    public function testExecuteWithNotExistCurrenciesThrowsException()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('app:currency-converter');
        $commandTester = new CommandTester($command);

        $this->expectException(\Exception::class);
        $commandTester->execute([
            'amount' => '10',
            'from' => 'NOT',
            'to' => 'CURRENCY'
        ]);
    }

    private function createPredisClient(): Client
    {
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(['BTC-USD'])
            )
            ->willReturn(self::EXCHANGE_RATE);
        return $predisClient;
    }
}

