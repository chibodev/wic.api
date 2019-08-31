<?php

declare(strict_types=1);

namespace App\Common\Exception;

use Exception;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class TokenAuthenticationException extends AuthenticationException
{
    protected $message;

    public function __construct(string $message)
    {
        $this->message = $message;
        Exception::__construct();
    }

    public function getMessageKey(): string
    {
        return $this->message;
    }
}
