<?php

declare(strict_types=1);

namespace App\Recipe\PublicInterface;

use App\Common\Security\DTO\AccessKey;
use App\Recipe\Entity\ApiUser as ApiUserEntity;
use Exception;
use Symfony\Component\Security\Core\User\User;

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

    /**
     * @throws Exception
     */
    public function verifyAccess(string $apiKey): User;
}
