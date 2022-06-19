<?php

namespace App\Repository;

use App\Entity\RestReason;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RestReason|null find($id, $lockMode = null, $lockVersion = null)
 * @method RestReason|null findOneBy(array $criteria, array $orderBy = null)
 * @method RestReason[]    findAll()
 * @method RestReason[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestReasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RestReason::class);
    }

    // /**
    //  * @return RestReason[] Returns an array of RestReason objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RestReason
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
