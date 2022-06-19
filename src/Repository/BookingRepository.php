<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findAll()
    {
        return $this->findBy(array(), array('beginAt' => 'DESC'));
    }

    

     /**
      * @return Booking[] Returns an array of Booking objects
      */
    
    public function findByCustomer($customer)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.booker = :val')
            ->setParameter('val', $customer)
            ->orderBy('b.beginAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCoiffeur($coiffeur)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.coiffeur = :val')
            ->setParameter('val', $coiffeur)
            ->orderBy('b.beginAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBySalon($salon)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.Salon = :val')
            ->setParameter('val', $salon)
            ->orderBy('b.beginAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
