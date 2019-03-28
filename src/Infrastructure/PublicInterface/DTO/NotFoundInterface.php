<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface\DTO;

interface NotFoundInterface
{
    public function getMessage(): string;

    public function setMessage(string $message): void;
}
