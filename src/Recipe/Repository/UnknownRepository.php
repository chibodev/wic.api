<?php

declare(strict_types=1);

namespace App\Recipe\Repository;

use App\Recipe\Entity\Unknown;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Exception;
use LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Unknown|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unknown|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unknown[]    findAll()
 * @method Unknown[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnknownRepository extends ServiceEntityRepository
{
    /**
     * @throws LogicException
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Unknown::class);
    }

    /**
     * @throws Exception
     */
    public function save(Unknown $unknown): void
    {
        try {
            $this->_em->persist($unknown);
            $this->_em->flush();
        } catch (ORMException | ORMInvalidArgumentException $exception) {
            throw new Exception(sprintf('Unable to save unknown search term %s', $unknown->getTerm()));
        }

    }
}
