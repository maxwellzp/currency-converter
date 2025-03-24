<?php

namespace App\Scheduler\Message;

class ProviderMessage
{
    public function __construct(private string $className)
    {
    }

    public function getClassName(): string
    {
        return $this->className;
    }
}
