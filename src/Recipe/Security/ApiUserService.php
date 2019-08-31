<?php

declare(strict_types=1);

namespace App\Recipe\Security;

use App\Common\Exception\TokenAuthenticationException;
use App\Common\Security\DTO\AccessKey as AccessKeyDTO;
use App\Common\Security\Service\AccessKey;
use App\Recipe\Entity\ApiUser as ApiUserEntity;
use App\Recipe\PublicInterface\ApiUser;
use App\Recipe\Repository\ApiUserRepository;
use Exception;
use Symfony\Component\Security\Core\User\User;

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

    public function verifyAccess(string $apiKey): User
    {
        if(!$this->isValid($apiKey)){
            throw new TokenAuthenticationException('Access forbidden! Invalid access token');
        }

        [$uuid, $hash] = $this->getAccessVerificationCredentials($apiKey);

        $apiUser = $this->repository->findOneBy(['uuid' => $uuid]);

        if (!$apiUser) {
            throw new TokenAuthenticationException('Access forbidden! Invalid user');
        }

        $authentication = hash_equals($hash, $apiUser->getHash()) && password_verify($apiUser->getUuid(), $hash);

        if (!$authentication) {
            throw new TokenAuthenticationException('Access forbidden!. No user associated with token');
        }

        return new User($apiUser->getUuid(), $apiUser->getHash(), $apiUser->getRoles());
    }

    private function isValid(string $apiKey): bool
    {
        $error_count = 0;

        if ($apiKey === '') {++$error_count;}
        if (!base64_decode($apiKey, true)) {++$error_count;}

        return $error_count === 0;
    }

    private function getAccessVerificationCredentials(string $apiKey)
    {
        return explode('.', base64_decode($apiKey, true), 2);
    }
}
