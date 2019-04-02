<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Common\App\Security\DTO\AccessKey;
use App\Infrastructure\Entity\ApiUser as ApiUserEntity;
use Exception;

interface ApiUser
{
    public const EVENT = 'create.save';

    /**
     * @throws Exception
     */
    public function createKey(string $userUuid): AccessKey;

    /**
     * @throws Exception
     */
    public function save(ApiUserEntity $apiUser);
}
