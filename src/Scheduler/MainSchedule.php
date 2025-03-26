<?php

declare(strict_types=1);

namespace App\Scheduler;

use App\Scheduler\Message\ProviderMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule('update-from-api')]
final class MainSchedule implements ScheduleProviderInterface
{
    public function __construct(
        private CacheInterface $cache,
    ) {
    }

    public function getSchedule(): Schedule
    {
        return (new Schedule())
            ->add(
                RecurringMessage::every('24 hours', new ProviderMessage('App\Providers\NBUProvider')),
                RecurringMessage::every('5 minutes', new ProviderMessage('App\Providers\BinanceProvider')),
                RecurringMessage::every('24 hours', new ProviderMessage('App\Providers\PrivatBankProvider')),
                RecurringMessage::every('5 minutes', new ProviderMessage('App\Providers\MonobankProvider')),
            )
            ->stateful($this->cache);
    }
}
