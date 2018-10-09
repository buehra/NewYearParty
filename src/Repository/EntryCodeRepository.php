<?php

namespace App\Repository;

use App\Entity\EntryCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EntryCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntryCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntryCode[]    findAll()
 * @method EntryCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntryCodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EntryCode::class);
    }

    public function findByCode($code)
    {
        return $this->createQueryBuilder('e')
            ->where('e.code = :value')
            ->andWhere('e.email is null')
            ->setParameter('value', $code)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
