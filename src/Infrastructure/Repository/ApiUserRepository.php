<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\ApiUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Exception;
use LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ApiUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiUser[]    findAll()
 * @method ApiUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiUserRepository extends ServiceEntityRepository
{
    /**
     * @throws LogicException
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ApiUser::class);
    }

    /**
     * @throws Exception
     */
    public function save(ApiUser $apiUser)
    {
        try {
            $this->_em->persist($apiUser);
            $this->_em->flush($apiUser);
        } catch (ORMException | OptimisticLockException | ORMInvalidArgumentException $e) {
            throw new Exception(sprintf('Unable to save new Api User %s', $apiUser->getUuid()));
        }
    }
}
