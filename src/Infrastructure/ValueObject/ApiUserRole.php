<?php

declare(strict_types=1);

namespace App\Infrastructure\ValueObject;

use MyCLabs\Enum\Enum;

class ApiUserRole extends Enum
{
    public const ROLE_API_USER = 'ROLE_API_USER';
    public const ROLE_API_ADMIN = 'ROLE_API_ADMIN';
}
