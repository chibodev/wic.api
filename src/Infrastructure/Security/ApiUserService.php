<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Common\Security\DTO\AccessKey as AccessKeyDTO;
use App\Common\Security\Service\AccessKey;
use App\Infrastructure\Entity\ApiUser as ApiUserEntity;
use App\Infrastructure\Repository\ApiUserRepository;
use Exception;
use InvalidArgumentException;

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

    public function verifyAccess(string $apiKey): bool
    {
        list($uuid, $hash) = $this->validate($apiKey);

        $apiUser = $this->repository->findOneBy(['uuid' => $uuid]);

        if (!$apiUser) {
            throw new Exception('Access forbidden! Invalid user');
        }

        return hash_equals($hash, $apiUser->getHash()) && password_verify($apiUser->getUuid(), $hash);
    }

    /**
     * @throws Exception
     */
    private function validate(string $apiKey): array
    {
        $error_count = 0;

        if ($apiKey === '') {++$error_count;}
        if (!base64_decode($apiKey, true)) {++$error_count;}

        if ($error_count) {
            throw new InvalidArgumentException(sprintf('Access forbidden! Error(s): %s on validating access key', $error_count));
        }

        return explode('.', base64_decode($apiKey, true), 2);
    }
}
