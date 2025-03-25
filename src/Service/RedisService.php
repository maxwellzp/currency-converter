<?php

declare(strict_types=1);

namespace App\Service;

use Predis\Client;
class RedisService
{
    private Client $redis;

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }
    public function set(string $key, string $value): void
    {
        $this->redis->set($key, $value);
    }

    public function get(string $key): ?string
    {
        return $this->redis->get($key);
    }
}