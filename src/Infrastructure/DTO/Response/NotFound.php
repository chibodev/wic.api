<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO\Response;

use App\Infrastructure\PublicInterface\DTO\NotFoundInterface;

class NotFound implements NotFoundInterface
{
    private $message;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
