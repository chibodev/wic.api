<?php

declare(strict_types=1);

namespace App\Recipe\Event;

use App\Common\Security\DTO\AccessKey;
use App\Recipe\ValueObject\ApiUserRole;
use Symfony\Component\EventDispatcher\Event;

class ApiUserEvent extends Event
{
    private $uuid;
    /** @var ApiUserRole */
    private $role;
    /** @var AccessKey */
    private $accessKey;

    public function __construct(string $uuid, ApiUserRole $role)
    {
        $this->uuid = $uuid;
        $this->role = $role;
    }

    public function getApiUserUuid(): string
    {
        return $this->uuid;
    }

    public function getRole(): ApiUserRole
    {
        return $this->role;
    }

    public function getResult(): AccessKey
    {
        return $this->accessKey;
    }

    public function setAccessKey(AccessKey $accessKey): void
    {
        $this->accessKey = $accessKey;
    }
}
