<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO\Response;

class NotFound
{
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
