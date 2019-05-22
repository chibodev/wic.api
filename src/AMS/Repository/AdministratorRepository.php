<?php

namespace App\AMS\Repository;

use App\AMS\Entity\Administrator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Exception;
use LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Administrator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Administrator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Administrator[]    findAll()
 * @method Administrator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdministratorRepository extends ServiceEntityRepository
{
    /**
     * @throws LogicException
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Administrator::class);
    }

    /**
     * @throws Exception
     */
    public function save(Administrator $moderator)
    {
        try {
            $this->_em->persist($moderator);
            $this->_em->flush($moderator);
        } catch (ORMException | ORMInvalidArgumentException $exception) {
            throw new Exception(sprintf('Unable to save new moderator with id %s', $moderator->getEmail()));
        }

    }
}
