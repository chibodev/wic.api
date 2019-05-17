<?php

declare(strict_types=1);

namespace App\Recipe\Security;

use App\Common\Security\DTO\AccessKey as AccessKeyDTO;
use App\Common\Security\Service\AccessKey;
use App\Recipe\Entity\ApiUser as ApiUserEntity;
use App\Recipe\PublicInterface\ApiUser;
use App\Recipe\Repository\ApiUserRepository;
use InvalidArgumentException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
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
            throw new InvalidArgumentException('Access forbidden! Error(s) while validating access key');
        }

        [$uuid, $hash] = $this->getAccessVerificationCredentials($apiKey);

        $apiUser = $this->repository->findOneBy(['uuid' => $uuid]);

        if (!$apiUser) {
            throw new AuthenticationException('Access forbidden! Invalid user');
        }

        $authentication = hash_equals($hash, $apiUser->getHash()) && password_verify($apiUser->getUuid(), $hash);

        if (!$authentication) {
            throw new UsernameNotFoundException('Access forbidden!. No user exists for the enter token');
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
