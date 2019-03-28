<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\Unknown;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Unknown|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unknown|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unknown[]    findAll()
 * @method Unknown[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnknownRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Unknown::class);
    }

    /**
     * @throws Exception
     */
    public function save(Unknown $unknown)
    {
        try {
            $this->_em->persist($unknown);
            $this->_em->flush();
        } catch (ORMException | ORMInvalidArgumentException $exception) {
            throw new Exception(sprintf('Unable to save unknown search term %s', $unknown->getTerm()));
        }

    }
}
