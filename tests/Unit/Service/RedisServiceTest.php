<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\RedisService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Predis\Client;

#[CoversClass(RedisService::class)]
class RedisServiceTest extends TestCase
{
    private RedisService $redisService;
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSetWithMockSuccessfully()
    {
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('set'),
                $this->equalTo(['key1', 'value1'])
            );
        $this->redisService = new RedisService($predisClient);
        $this->redisService->set('key1', 'value1');
    }

    public function testGetWithExistingKeySuccessfully()
    {
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(['key1'])
            )
            ->willReturn('value1');
        $this->redisService = new RedisService($predisClient);
        $actualResult = $this->redisService->get('key1');
        $this->assertNotNull($actualResult);
        $this->assertEquals('value1', $actualResult);
    }

    public function testGetWithNotExistingKeyReturnsNull()
    {
        $predisClient = $this->createMock(Client::class);
        $predisClient
            ->expects($this->once())
            ->method('__call')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(['key2'])
            )
            ->willReturn(null);
        $this->redisService = new RedisService($predisClient);
        $actualResult = $this->redisService->get('key2');
        $this->assertNull($actualResult);
    }
}
