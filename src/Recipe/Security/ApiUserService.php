<?php

declare(strict_types=1);

namespace App\Recipe\Security;

use App\Common\Security\DTO\AccessKey as AccessKeyDTO;
use App\Common\Security\Service\AccessKey;
use App\Recipe\Entity\ApiUser as ApiUserEntity;
use App\Recipe\Repository\ApiUserRepository;
use Exception;
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
        [$uuid, $hash] = $this->validate($apiKey);

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
