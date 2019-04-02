<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Common\App\Security\DTO\AccessKey as AccessKeyDTO;
use App\Common\App\Security\Service\AccessKey;
use App\Infrastructure\Entity\ApiUser as ApiUserEntity;
use App\Infrastructure\Repository\ApiUserRepository;

class ApiUserService implements ApiUser
{
    private $accessKey;
    private $repository;

    public function __construct(AccessKey $accessKey, ApiUserRepository $repository)
    {
        $this->accessKey = $accessKey;
        $this->repository = $repository;
    }

    public function createKey(string $userUuid): AccessKeyDTO
    {
        return $this->accessKey->generateForApi($userUuid);
    }

    public function save(ApiUserEntity $apiUser): void
    {
        $this->repository->save($apiUser);
    }
}
